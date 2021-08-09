<?php
//セッションを開始
session_start();
//セッションIDを更新して変更（セッションハイジャック対策）
session_regenerate_id( TRUE );
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require 'libs/functions.php';
//reCAPTCHA ウィジェットを表示する場合は以下と API 読み込み（94行目）のコメントアウトを外す
//require '../libs/recaptchavars.php'; //reCAPTCHA サイトキーを記述したファイルの読み込み
//$siteKey = V3_SITEKEY; // reCAPTCHA サイトキー
//初回以外ですでにセッション変数に値が代入されていれば、その値を。そうでなければNULLで初期化
$name = isset( $_SESSION[ 'name' ] ) ? $_SESSION[ 'name' ] : NULL;
$email = isset( $_SESSION[ 'email' ] ) ? $_SESSION[ 'email' ] : NULL;
$email_check = isset( $_SESSION[ 'email_check' ] ) ? $_SESSION[ 'email_check' ] : NULL;
$tel = isset( $_SESSION[ 'tel' ] ) ? $_SESSION[ 'tel' ] : NULL;
$subject = isset( $_SESSION[ 'subject' ] ) ? $_SESSION[ 'subject' ] : NULL;
$body = isset( $_SESSION[ 'body' ] ) ? $_SESSION[ 'body' ] : NULL;
$error = isset( $_SESSION[ 'error' ] ) ? $_SESSION[ 'error' ] : NULL;
//個々のエラーを初期化
$error_name = isset( $error['name'] ) ? $error['name'] : NULL;
$error_email = isset( $error['email'] ) ? $error['email'] : NULL;
$error_email_check = isset( $error['email_check'] ) ? $error['email_check'] : NULL;
$error_tel = isset( $error['tel'] ) ? $error['tel'] : NULL;
$error_tel_format = isset( $error['tel_format'] ) ? $error['tel_format'] : NULL;
$error_subject = isset( $error['subject'] ) ? $error['subject'] : NULL;
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
  <title>お問い合わせ | U-cafe 【公式】あなたとわたしのカフェ。| 熊本市東区</title>
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
        <h2 class="mt_50">Contact</h2>
        <p class="sub_t mb_60">お問い合わせ</p>
      </div>
      <div class="ta-l">
        <p>お気軽にお問い合わせください。<br>以下のフォームに必要事項をご入力いただき、送信ボタンを押してください。<br>
          すべて必須項目になります。 </p>
      </div>

      <div class="con-phase">
        <form id="main_contact" method="post" action="confirm.php">
          <!-- 〓〓〓〓〓〓 -->
          <div class="form-group ta-l">
            <label for="subject">お問い合わせの種類
              <span class="error"><?php echo h( $error_subject ); ?></span>
            </label>
            <div class="select">
              <select name="subject" lass="form-control validate max100 required" id="subject" name="subject"
                placeholder="件名">
                <option value="" selected="selected">選択してください</option>
                <option value="予約する">予約する（当日のご予約は電話で確認をお願いします。）</option>
                <option value="オーダークッキーについて">オーダークッキーについて</option>
                <option value="ケーキの注文">ケーキの注文</option>
                <option value="その他">その他</option>
              </select>
            </div>
          </div>
          <!-- 〓〓〓〓〓〓 -->
          <div class="form-group">
            <label for="name">お名前
              <span class="error"><?php echo h( $error_name ); ?></span>
            </label>
            <input type="text" class="form-control validate max50 required" id="name" name="name" placeholder="氏名"
              value="<?php echo h($name); ?>">
          </div>
          <!-- 〓〓〓〓〓〓 -->
          <div class="form-group">
            <label for="email">Email
              <span class="error"><?php echo h( $error_email ); ?></span>
            </label>
            <input type="text" class="form-control validate mail required" id="email" name="email"
              placeholder="xxx@xxx.com" value="<?php echo h($email); ?>">
          </div>
          <!-- 〓〓〓〓〓〓 -->
          <div class="form-group">
            <label for="email_check">Email *確認用
              <span class="error"><?php echo h( $error_email_check ); ?></span>
            </label>
            <input type="text" class="form-control validate email_check required" id="email_check" name="email_check"
              placeholder="xxx@xxx.com（確認のためもう一度ご入力ください。）" value="<?php echo h($email_check); ?>">
          </div>
          <!-- 〓〓〓〓〓〓 -->
          <div class="form-group">
            <label for="tel">お電話番号 *半角英数字
              <span class="error"><?php echo h( $error_tel ); ?></span>
              <span class="error"><?php echo h( $error_tel_format ); ?></span>
            </label>
            <input type="text" class="validate max30 tel form-control required" id="tel" name="tel"
              value="<?php echo h($tel); ?>" placeholder="09000000000 (ハイフン無し)">
          </div>
          <!-- 〓〓〓〓〓〓 -->
          <div class="form-group">
            <label for="body">お問い合わせ内容
              <span class="error"><?php echo h( $error_body ); ?></span>
            </label>
            <div class="d-b">
              <span id="count"> </span>/1000
            </div>
            <textarea class="form-control validate max1000 required" id="body" name="body"
              placeholder="お問い合わせ（1000文字まで）" rows="3"><?php echo h($body); ?></textarea>
          </div>
      </div>
      <!-- 〓〓〓〓〓〓 -->
      <div class="btn-8">
        <button type="submit" class="btn btn-primary">確認画面へ</button>
        <!--確認ページへトークンをPOSTする、隠しフィールド「ticket」-->
        <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
      </div>
      </form>
    </div>
    <!-- reCAPTCHA ウィジェットを表示する場合は以下のコメントアウトを外す -->
    <!--<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $siteKey; ?>"></script>-->

    <!-- footer -->
    <div class="main_contact">
      <img loading="lazy" class="main_con_i fadeUpTrigger" src="img/u-cafe-logo_black.png" alt="ロゴ黒">
      <p class="main_con_p fadeUpTrigger">You and Me Café</p>
      <div class="main_cons d-f jc-c fadeUpTrigger">
        <img src="img/kari/footer.jpg" alt="">
      </div>
      <div class="btn-5 fadeUpTrigger">
        <a href="contact.php">
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


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script>
  jQuery(function($) {

    //エラーを表示する関数（error クラスの p 要素を追加して表示）
    function show_error(message, this$) {
      text = this$.parent().find('label').text() + message;
      this$.parent().append("<p class='error'>" + text + "</p>");
    }

    //フォームが送信される際のイベントハンドラの設定
    $("#main_contact").submit(function() {
      //エラー表示の初期化
      $("p.error").remove();
      $("div").removeClass("error");
      var text = "";
      $("#errorDispaly").remove();

      //メールアドレスの検証
      var email = $.trim($("#email").val());
      if (email && !(/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/gi).test(email)) {
        $("#email").after("<p class='error'>メールアドレスの形式が異なります</p>");
      }
      //確認用メールアドレスの検証
      var email_check = $.trim($("#email_check").val());
      if (email_check && email_check != $.trim($("input[name=" + $("#email_check").attr("name").replace(
          /^(.+)_check$/, "$1") + "]").val())) {
        show_error("が異なります", $("#email_check"));
      }
      //電話番号の検証
      var tel = $.trim($("#tel").val());
      if (tel && !(/^\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}$/gi).test(tel)) {
        $("#tel").after("<p class='error'>電話番号の形式が異なります（半角英数字でご入力ください）</p>");
      }

      //1行テキスト入力フォームとテキストエリアの検証
      $(":text,textarea").filter(".validate").each(function() {
        //必須項目の検証
        $(this).filter(".required").each(function() {
          if ($(this).val() == "") {
            show_error(" は必須項目です", $(this));
          }
        });
        //文字数の検証
        $(this).filter(".max30").each(function() {
          if ($(this).val().length > 30) {
            show_error(" は30文字以内です", $(this));
          }
        });
        $(this).filter(".max50").each(function() {
          if ($(this).val().length > 50) {
            show_error(" は50文字以内です", $(this));
          }
        });
        $(this).filter(".max100").each(function() {
          if ($(this).val().length > 100) {
            show_error(" は100文字以内です", $(this));
          }
        });
        //文字数の検証
        $(this).filter(".max1000").each(function() {
          if ($(this).val().length > 1000) {
            show_error(" は1000文字以内でお願いします", $(this));
          }
        });
      });

      //error クラスの追加の処理
      if ($("p.error").length > 0) {
        $("p.error").parent().addClass("error");
        $('html,body').animate({
          scrollTop: $("p.error:first").offset().top - 180
        }, 'slow');
        return false;
      }
    });

    //テキストエリアに入力された文字数を表示
    $("textarea").on('keydown keyup change', function() {
      var count = $(this).val().length;
      $("#count").text(count);
      if (count > 1000) {
        $("#count").css({
          color: 'red',
          fontWeight: 'bold'
        });
      } else {
        $("#count").css({
          color: '#333',
          fontWeight: 'normal'
        });
      }
    });
  })
  </script>
</body>

</html>