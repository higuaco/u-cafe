<?php
//セッションを開始
session_start();
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require 'libs/functions.php';

//reCAPTCHA サイトキーを記述したファイルの読み込み（★追加）
require 'libs/recaptchavars.php';
// reCAPTCHA サイトキー（★追加）
$siteKey = V3_SITEKEY;

//POSTされたデータをチェック
$_POST = checkInput( $_POST );
//固定トークンを確認（CSRF対策）
if ( isset( $_POST[ 'ticket' ], $_SESSION[ 'ticket' ] ) ) {
  $ticket = $_POST[ 'ticket' ];
  if ( $ticket !== $_SESSION[ 'ticket' ] ) {
    //トークンが一致しない場合は処理を中止
    die( 'Access Denied!' );
  }
} else {
  //トークンが存在しない場合は処理を中止（直接このページにアクセスするとエラーになる）
  die( 'Access Denied（直接このページにはアクセスできません）' );
}
//POSTされたデータを変数に格納
$name = isset( $_POST[ 'name' ] ) ? $_POST[ 'name' ] : NULL;
$email = isset( $_POST[ 'email' ] ) ? $_POST[ 'email' ] : NULL;
$email_check = isset( $_POST[ 'email_check' ] ) ? $_POST[ 'email_check' ] : NULL;
$tel = isset( $_POST[ 'tel' ] ) ? $_POST[ 'tel' ] : NULL;
$subject = isset( $_POST[ 'subject' ] ) ? $_POST[ 'subject' ] : NULL;
$body = isset( $_POST[ 'body' ] ) ? $_POST[ 'body' ] : NULL;
//POSTされたデータを整形（前後にあるホワイトスペースを削除）
$name = trim( $name );
$email = trim( $email );
$email_check = trim( $email_check );
$tel = trim( $tel );
$subject = trim( $subject );
$body = trim( $body );
//エラーメッセージを保存する配列の初期化
$error = array();
//値の検証（入力内容が条件を満たさない場合はエラーメッセージを配列 $error に設定）
if ( $name == '' ) {
  $error[ 'name' ] = '*お名前は必須項目です。';
  //制御文字でないことと文字数をチェック
} else if ( preg_match( '/\A[[:^cntrl:]]{1,30}\z/u', $name ) == 0 ) {
  $error[ 'name' ] = '*お名前は30文字以内でお願いします。';
}
if ( $email == '' ) {
  $error[ 'email' ] = '*メールアドレスは必須です。';
} else { //メールアドレスを正規表現でチェック
  $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/uiD';
  if ( !preg_match( $pattern, $email ) ) {
    $error[ 'email' ] = '*メールアドレスの形式が正しくありません。';
  }
}
if ( $email_check == '' ) {
  $error[ 'email_check' ] = '*確認用メールアドレスは必須です。';
} else { //メールアドレスを正規表現でチェック
  if ( $email_check !== $email ) {
    $error[ 'email_check' ] = '*メールアドレスが一致しません。';
  }
}
if ( preg_match( '/\A[[:^cntrl:]]{0,30}\z/u', $tel ) == 0 ) {
  $error[ 'tel' ] = '*電話番号は30文字以内でお願いします。';
}
if ( $tel != '' && preg_match( '/\A\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}\z/u', $tel ) == 0 ) {
  $error[ 'tel_format' ] = '*電話番号の形式が正しくありません。';
}
if ( $subject == '' ) {
  $error[ 'subject' ] = '*件名は必須項目です。';
  //制御文字でないことと文字数をチェック
} else if ( preg_match( '/\A[[:^cntrl:]]{1,100}\z/u', $subject ) == 0 ) {
  $error[ 'subject' ] = '*件名は100文字以内でお願いします。';
}
if ( $body == '' ) {
  $error[ 'body' ] = '*内容は必須項目です。';
  //制御文字（タブ、復帰、改行を除く）でないことと文字数をチェック
} else if ( preg_match( '/\A[\r\n\t[:^cntrl:]]{1,1050}\z/u', $body ) == 0 ) {
  $error[ 'body' ] = '*内容は1000文字以内でお願いします。';
}
//POSTされたデータとエラーの配列をセッション変数に保存
$_SESSION[ 'name' ] = $name;
$_SESSION[ 'email' ] = $email;
$_SESSION[ 'email_check' ] = $email_check;
$_SESSION[ 'tel' ] = $tel;
$_SESSION[ 'subject' ] = $subject;
$_SESSION[ 'body' ] = $body;
$_SESSION[ 'error' ] = $error;
//チェックの結果にエラーがある場合は入力フォームに戻す
if ( count( $error ) > 0 ) {
  //エラーがある場合
  $dirname = dirname( $_SERVER[ 'SCRIPT_NAME' ] );
  $dirname = $dirname == DIRECTORY_SEPARATOR ? '' : $dirname;
  $url = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER[ 'SERVER_NAME' ] . $dirname . '/contact.php';
  header( 'HTTP/1.1 303 See Other' );
  header( 'location: ' . $url );
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="keyword" content="u-cafe,熊本カフェ,熊本パフェ">
  <meta name="description" content="あなたとわたしのカフェ。U-cafe。山小屋をイメージした木のぬくもりが温かい空間で、元パティシエがつくる洗練された料理をあなたに。">
  <meta name="robots" content="noindex,nofollow">
  <title>お問い合わせ（確認） | U-cafe 【公式】あなたとわたしのカフェ。| 熊本市東区</title>
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
  <div class="inner">
    <div class="container">
      <p class="nerp-1">お問い合わせ確認画面</p>
      <p class="nerp-2">以下の内容でよろしければ「送信する」をクリックしてください。<br>
        内容を変更する場合は「戻る」をクリックして入力画面にお戻りください。</p>
      <div class="conf_table1">
        <table class="conf_table2">
          <caption>ご入力内容</caption>
          <tr>
            <th>お問い合わせの種類</th>
            <td><?php echo h($subject); ?></td>
          </tr>
          <tr>
            <th>お名前</th>
            <td><?php echo h($name); ?></td>
          </tr>
          <tr>
            <th>Email</th>
            <td><?php echo h($email); ?></td>
          </tr>
          <tr>
            <th>お電話番号</th>
            <td><?php echo h($tel); ?></td>
          </tr>
          <tr>
            <th style="white-space: nowrap;">お問い合わせ内容</th>
            <td><?php echo nl2br(h($body)); ?></td>
          </tr>
        </table>
      </div>
      <form action="contact.php" method="post" class="confirm">
        <div class="btn-9"><button type="submit" class="btn btn-secondary">戻る</button></div>
      </form>
      <form id="complete" action="complete.php" method="post" class="confirm">
        <!--  id="complete" （★追加）-->
        <!-- 完了ページへ渡すトークンの隠しフィールド -->
        <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
        <div class="btn-10"><button type="submit" class="btn btn-success">送信する</button></div>
      </form>
    </div>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $siteKey; ?>"></script>
    <!-- reCAPTCHA v3 の読み込み（★追加） -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script><!-- jQuery の読み込み（★追加） -->
    <script>
    //reCAPTCHA v3 トークン取得（★追加）
    jQuery(function($) {
      $("#complete").submit(function(event) {
        var that = $(this);
        event.preventDefault();
        var action_name = 'contact'; //アクション名
        grecaptcha.ready(function() {
          grecaptcha.execute('<?php echo $siteKey; ?>', {
            action: action_name
          }).then(function(token) {
            //input 要素を生成して値にトークンを設定
            that.prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
            //input 要素を生成して値にアクション名を設定
            that.prepend('<input type="hidden" name="action" value="' + action_name + '">');
            //unbind で一度 submit のイベントハンドラを削除してから submit() を実行
            that.unbind('submit').submit();
          });;
        });
      });
    })
    </script>
</body>

</html>