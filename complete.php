<?php
//セッションを開始
session_start();
//エスケープ処理やデータをチェックする関数を記述したファイルの読み込み
require 'libs/functions.php';
//メールアドレス等を記述したファイルの読み込み
require 'libs/mailvars.php';

//reCAPTCHA サイトキーを記述したファイルの読み込み（★追加）
require 'libs/recaptchavars.php';
// reCAPTCHA サイトキー（★追加）
$siteKey = V3_SITEKEY;
// reCAPTCHA シークレットキー（★追加）
$secretKey = V3_SECRETKEY;

//POSTされたデータをチェック
$_POST = checkInput( $_POST );
//固定トークンを確認（CSRF対策）
if ( isset( $_POST[ 'ticket' ], $_SESSION[ 'ticket' ] ) ) {
  $ticket = $_POST[ 'ticket' ];
  if ( $ticket !== $_SESSION[ 'ticket' ] ) {
    //トークンが一致しない場合は処理を中止
    die( 'Access denied' );
  }
} else {
  //トークンが存在しない場合（入力ページにリダイレクト）
  //die( 'Access Denied（直接このページにはアクセスできません）' );  //処理を中止する場合
  $dirname = dirname( $_SERVER[ 'SCRIPT_NAME' ] );
  $dirname = $dirname == DIRECTORY_SEPARATOR ? '' : $dirname;
  $url = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER[ 'SERVER_NAME' ] . $dirname . '/contact.php';
  header( 'HTTP/1.1 303 See Other' );
  header( 'location: ' . $url );
  exit; //忘れないように
}

//reCAPTCHA トークン（★追加）
$token = isset( $_POST[ 'g-recaptcha-response' ] ) ? $_POST[ 'g-recaptcha-response' ] : NULL;
//reCAPTCHA アクション名 （★追加）
$action = isset( $_POST[ 'action' ] ) ? $_POST[ 'action' ] : NULL;
//reCAPTCHA の検証を通過したかどうかの真偽値（★追加）
$rcv3_result = false;
echo $token;
echo $action;

// reCAPTCHA のトークンとアクション名が取得できていれば（★追加）
if ( $token && $action ) {

  //cURL セッションを初期化（API のレスポンスの取得）
  $ch = curl_init();
  // curl_setopt() により転送時のオプションを設定
  //URL の指定
  curl_setopt( $ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify" );
  //HTTP POST メソッドを使う
  curl_setopt( $ch, CURLOPT_POST, true );
  //API パラメータの指定
  curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( array(
    'secret' => $secretKey,
    'response' => $token
  ) ) );
  //curl_execの返り値を文字列にする
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  //転送を実行してレスポンスを $api_response に格納
  $api_response = curl_exec( $ch );
  //セッションを終了
  curl_close( $ch );

  //レスポンスの $json（JSON形式）をデコード
  $rc_result = json_decode( $api_response );

  //レスポンスの値を判定
  if ( $rc_result->success && $rc_result->action === $action && $rc_result->score >= 0.5 ) {
    //success が true でアクション名が一致し、スコアが 0.5 以上の場合は合格
    $rcv3_result = true;
  } else {
    // 上記以外の場合は 不合格
    $rcv3_result = false;
  }
}

//メールの送信結果の初期値を false に
$result = false;

//reCAPTCHA の検証結果が合格の場合はメール送信処理を実行
if ( $rcv3_result ) { //（★追加）

  //お問い合わせ日時を日本時間に
  date_default_timezone_set( 'Asia/Tokyo' );

  //変数にエスケープ処理したセッション変数の値を代入
  $subject = h( $_SESSION[ 'subject' ] );
  $name = h( $_SESSION[ 'name' ] );
  $ruby = h( $_SESSION[ 'ruby' ] );
  $tel = h( $_SESSION[ 'tel' ] );
  $email = h( $_SESSION[ 'email' ] );
  $body = h( $_SESSION[ 'body' ] );

  //メール本文の組み立て
  $mail_body = 'コンタクトページからのお問い合わせ' . "\n\n";
  $mail_body .= date( "Y年m月d日 H時i分" ) . "\n\n";
  $mail_body .= "お名前： " . $name . "\n";
  $mail_body .= "フリガナ： " . $ruby . "\n";
  $mail_body .= "お電話番号： " . $tel . "\n\n";
  $mail_body .= "Email： " . $email . "\n";
  $mail_body .= "＜お問い合わせ内容＞" . "\n" . $body;

  //-------- sendmail（mb_send_mail）を使ったメールの送信処理------------

  //メールの宛先（名前<メールアドレス> の形式）。値は mailvars.php に記載
  $mailTo = mb_encode_mimeheader( MAIL_TO_NAME ) . "<" . MAIL_TO . ">";

  //Return-Pathに指定するメールアドレス
  $returnMail = MAIL_RETURN_PATH; //
  //mbstringの日本語設定
  mb_language( 'ja' );
  mb_internal_encoding( 'UTF-8' );

  // 送信者情報（From ヘッダー）の設定
  $header = "From: " . mb_encode_mimeheader( $name ) . "<" . $email . ">\n";
  $header .= "Cc: " . mb_encode_mimeheader( MAIL_CC_NAME ) . "<" . MAIL_CC . ">\n";
  $header .= "Bcc: <" . MAIL_BCC . ">";

  //メールの送信（結果を変数 $result に格納）
  if ( ini_get( 'safe_mode' ) ) {
    //セーフモードがOnの場合は第5引数が使えない
    $result = mb_send_mail( $mailTo, $subject, $mail_body, $header );
  } else {
    $result = mb_send_mail( $mailTo, $subject, $mail_body, $header, '-f' . $returnMail );
  }
}

//メール送信の結果で分岐
if ( $result ) {
  //成功した場合はセッションを破棄
  $_SESSION = array(); //空の配列を代入し、すべてのセッション変数を消去
  session_destroy(); //セッションを破棄

echo $result;

  //自動返信メールの送信処理
  //自動返信メールの送信が成功したかどうかのメッセージを表示する場合は true
  $show_autoresponse_msg = true;
  //ヘッダー情報
  $ar_header = "MIME-Version: 1.0\n";
  $ar_header .= "From: " . mb_encode_mimeheader( AUTO_REPLY_NAME ) . " <" . MAIL_TO . ">\n";
  $ar_header .= "Reply-To: " . mb_encode_mimeheader( AUTO_REPLY_NAME ) . " <" . MAIL_TO . ">\n";
  //件名
  $ar_subject = 'お問い合わせ自動返信メール';
  //本文
  $ar_body = $name." 様\n\n";
  $ar_body .= "この度は、お問い合わせ頂き誠にありがとうございます。" . "\n\n";
  $ar_body .= "下記の内容でお問い合わせを受け付けました。\n\n";
  $ar_body .= "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
  $ar_body .= "お名前：" . $name . "\n";
  $ar_body .= "メールアドレス：" . $email . "\n";
  $ar_body .= "お電話番号： " . $tel . "\n\n" ;
  $ar_body .="＜お問い合わせ内容＞" . "\n" . $body;

  //自動返信の送信（結果を変数 result2 に格納）
  if ( ini_get( 'safe_mode' ) ) {
    $result2 = mb_send_mail( $email, $ar_subject, $ar_body , $ar_header  );
  } else {
    $result2 = mb_send_mail( $email, $ar_subject, $ar_body , $ar_header , '-f' . $returnMail );
  }

} else {
  //送信失敗時（もしあれば）
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="keyword" content="u-cafe,熊本カフェ,熊本パフェ">
  <meta name="description" content="あなたとわたしのカフェ。U-cafe。山小屋をイメージした木のぬくもりが温かい空間で、元パティシエがつくる洗練された料理をあなたに。">
  <meta name="robots" content="noindex,nofollow">
  <title>コンタクトフォーム（完了） | U-cafe 【公式】あなたとわたしのカフェ。| 熊本市東区</title>
  <!-- favicon用 -->
  <link rel="shortcut icon" href="favicon/icon.ico">
  <link rel="apple-touch-icon" href="favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="favicon/android-chrome-192x192.png">

  <meta name="viewport"
    content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/preset.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/jquery.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>


<body>
  <div class="container">
    <h2>お問い合わせフォーム</h2>
    <?php if ( $result ): ?>
    <h3>送信完了!</h3>
    <p>お問い合わせいただきありがとうございます。</p>
    <p>送信完了いたしました。</p>
    <?php else: ?>
    <p>申し訳ございませんが、送信に失敗しました。</p>
    <p>しばらくしてもう一度お試しになるか、電話にてご連絡ください。</p>
    <p>ご迷惑をおかけして誠に申し訳ございません。</p>
    <?php endif; ?>

    <!-- ここから reCAPTCHA 結果表示（テスト用）-->
    <?php if (isset($rc_result )): ?>
    <h4 style="margin: 20px 0;">reCAPTCHA 判定結果表示</h4>
    <ul>
      <li><?php echo 'success 判定 ：' . $rc_result->success; ?></li>
      <li><?php echo 'アクション名 ： ' . $rc_result->action ?></li>
      <li><?php echo 'スコア ： ' . $rc_result->score; ?></li>
    </ul>
    <h4 style="margin: 20px 0;">reCAPTCHA API レスポンス</h4>
    <pre><?php var_dump($rc_result ); ?></pre>
    <?php endif; ?>
    <!-- ここまで reCAPTCHA 結果表示（テスト用）-->

  </div>
  <script src="script.js"></script>
</body>

</html>