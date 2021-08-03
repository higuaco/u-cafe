<?php
//セッションを開始
session_start();

//セッションIDを更新して変更（セッションハイジャック対策）
session_regenerate_id( TRUE );

//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require 'libs/functions.php';

//初回以外ですでにセッション変数に値が代入されていれば、その値を。そうでなければNULLで初期化
$subject = isset( $_SESSION[ 'subject' ] ) ? $_SESSION[ 'subject' ] : NULL;
$name = isset( $_SESSION[ 'name' ] ) ? $_SESSION[ 'name' ] : NULL;
$ruby = isset( $_SESSION[ 'ruby' ] ) ? $_SESSION[ 'ruby' ] : NULL;
$tel = isset( $_SESSION[ 'tel' ] ) ? $_SESSION[ 'tel' ] : NULL;
$email = isset( $_SESSION[ 'email' ] ) ? $_SESSION[ 'email' ] : NULL;
$email_check = isset( $_SESSION[ 'email_check' ] ) ? $_SESSION[ 'email_check' ] : NULL;
$body = isset( $_SESSION[ 'body' ] ) ? $_SESSION[ 'body' ] : NULL;
$error = isset( $_SESSION[ 'error' ] ) ? $_SESSION[ 'error' ] : NULL;

//個々のエラーを初期化
$error_subject = isset( $error['subject'] ) ? $error['subject'] : NULL;
$error_name = isset( $error['name'] ) ? $error['name'] : NULL;
$error_ruby = isset( $error['ruby'] ) ? $error['ruby'] : NULL;
$error_tel = isset( $error['tel'] ) ? $error['tel'] : NULL;
$error_tel_format = isset( $error['tel_format'] ) ? $error['tel_format'] : NULL;
$error_email = isset( $error['email'] ) ? $error['email'] : NULL;
$error_email_check = isset( $error['email_check'] ) ? $error['email_check'] : NULL;
$error_body = isset( $error['body'] ) ? $error['body'] : NULL;
//CSRF対策の固定トークンを生成
if ( !isset( $_SESSION[ 'ticket' ] ) ) {
  //セッション変数にトークンを代入
  $_SESSION[ 'ticket' ] = sha1( uniqid( mt_rand(), TRUE ) );
}
//トークンを変数に代入
$ticket = $_SESSION[ 'ticket' ];
?>





<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="keyword" content="u-cafe,熊本カフェ,熊本パフェ">
  <meta name="description" content="あなたとわたしのカフェ。U-cafe。山小屋をイメージした木のぬくもりが温かい空間で、元パティシエがつくる洗練された料理をあなたに。">
  <meta name="robots" content="noindex,nofollow">
  <title>Photo お問い合わせ | U-cafe 【公式】あなたとわたしのカフェ。| 熊本市東区</title>
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
</head>

<body>
  <!-- headerー -->
  <header>
    <div class="header_under_index header_under_index-bk">
      <div class="inner">
        <!-- nav -->
        <div class="nav">
          <h1><a class="hov" href="/"><img src="img/u-cafe-logo_black.png" alt="黒ロゴ。u-cafe.あなたとわたしのカフェ。| 熊本市東区"></a>
          </h1>
          <!-- ヘッダーナビ 項目部分 -->
          <div class="nav_li">
            <ul>
              <li><a class="hov_nav_b" href="index.html#aboutus">ABOUT US</a></li>
              <li><a class="hov_nav_b" href="index.html#news">NEWS</a></li>
              <li><a class="hov_nav_b" href="photo.html">PHOTO</a></li>
              <li><a class="hov_nav_b" href="shop.html">ONLINE SHOP</a></li>
              <li><a class="hov_nav_b" href="index.html#access">ACCESS</a></li>
              <li><a class="hov_nav_b" href="contact.php">CONTACT</a></li>
              <li><a href="https://www.instagram.com/u_cafe_201710/?hl=ja" target="_blank"><img
                    src="img/glyph-logo_May2016.png" alt="黒"><img class="insta_hov" src="img/insta_color.png"
                    alt="カラー "></a></li>
            </ul>
          </div>
        </div>
      </div>
      <!-- .inner div -->
    </div>
  </header>
  <main>
    <div class="inner">
      <div class="con-cen ta-c">
        <h2 class="mt_50 fadeUpTrigger">Contact</h2>
        <p class="sub_t mb_60 fadeUpTrigger">お問い合わせ</p>
      </div>
      <div class="ta-l fadeUpTrigger">
        <p>お気軽にお問い合わせください。<br>以下のフォームに必要事項をご入力いただき、送信ボタンを押してください。<br>（<span class="c-red">＊</span>マークは必須項目です。）</p>
      </div>
      <div>
        <form id="mailform" action="#" method="POST">
          <div class="con-phase fadeUpTrigger">
            <table>
              <tbody>
                <tr>
                  <th>お問い合わせの種類
                    <span class="error"><?php echo h( $error_subject ); ?></span>
                  </th>
                  <td>

                    <div class="select">
                      <select name="subject">
                        <option value="" selected="selected">選択してください</option>
                        <option value="予約">予約する（当日のご予約は電話で確認をお願いします。）</option>
                        <option value="オーダークッキー">オーダークッキーについて</option>
                        <option value="ケーキの注文">ケーキの注文</option>
                        <option value="その他">その他</option>
                      </select>
                    </div>

                  </td>
                </tr>
                <tr>
                  <th><span class="c-red">＊</span>お名前
                    <span class="error"><?php echo h( $error_name ); ?></span>
                  </th>
                  <td><input type="text" class="form-control validate max50 required" id="name" name="name"
                      placeholder="氏名" value="<?php echo h($name); ?>">
                  </td>
                </tr>
                <tr>
                  <th><span class="c-red">＊</span> フリガナ
                    <span class="error"><?php echo h( $error_ruby ); ?></span>
                  </th>
                  <td><input type="text" name="ruby" required="required" data-charcheck="kana" /></td>
                </tr>
                <tr>
                  <th><span class="c-red">＊</span>電話番号　"-"(ハイフン)は不要です。
                    <span class="error"><?php echo h( $error_tel ); ?></span>
                    <span class="error"><?php echo h( $error_tel_format ); ?></span>
                  </th>
                  <td>
                    <input type="text" class="validate max30 tel form-control" id="tel" name="tel"
                      value="<?php echo h($tel); ?>" placeholder="お電話番号（半角英数字でご入力ください）">
                  </td>
                </tr>
                <tr>
                  <th><span class="c-red">＊</span> メールアドレス
                    <span class="error"><?php echo h( $error_email ); ?></span>
                  </th>
                  <td><input type="text" class="form-control validate mail required" id="email" name="email"
                      placeholder="Email アドレス" value="<?php echo h($email); ?>">
                  </td>
                </tr>
                <tr>
                  <th><span class="c-red">＊</span> メールアドレス　確認用
                    <span class="error"><?php echo h( $error_email_check ); ?></span>
                  </th>
                  <td><input type="text" class="form-control validate email_check required" id="email_check"
                      name="email_check" placeholder="Email アドレス（確認のためもう一度ご入力ください。）"
                      value="<?php echo h($email_check); ?>">
                  </td>
                </tr>
                <tr>
                  <th>自由入力欄
                    <span class="error"><?php echo h( $error_body ); ?></span>
                  </th>
                  <td>
                    <textarea name="body" rows="30" cols="60"></textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="btn-8 fadeUpTrigger">
            <button type="submit" class="hov mfp_element_submit mfp_element_all">入力確認画面へ進む</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.inner -->

    <!-- footer -->
    <div class="main_contact">
      <img loading="lazy" class="main_con_i fadeUpTrigger" src="img/u-cafe-logo_black.png" alt="ロゴ黒">
      <p class="main_con_p fadeUpTrigger">You and Me Café</p>
      <div class="main_cons d-f jc-c fadeUpTrigger">
        <div class="main_con_i_1"></div>
        <div class="main_con_i_2"></div>
      </div>
      <div class="btn-5 fadeUpTrigger">
        <a href="contact.html">
          <div class="con_1 fadeUpTrigger">
            <h3>Contact</h3>
            <p class="con_2">U-cafeへのお問い合わせはこちらから</p>
          </div>
        </a>
      </div>
      <a class="hov" href="/"><img loading="lazy" class="con_3 fadeUpTrigger" src="img/u-cafe_maki.png" alt=""></a>
      <div class="inner">
        <div class="con_4 fadeUpTrigger"></div>
      </div>
    </div>
  </main>
  <footer class="fadeUpTrigger">
    <small>Copyright &copy Sheepontaneous,All rights reserved.</small>
  </footer>
  <script src="script.js"></script>
</body>

</html>