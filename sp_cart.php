<?php
//個数
$number = $_POST['number'];
// サイズ
$size = $_POST['size'];
// プレーン(1)or抹茶(2)
$genre = $_POST['genre'];

// チーズケーキプレーン
$priceCheesePlane_S = 1000;
$priceCheesePlane_M = 2000;
$priceCheesePlane_L = 3000;

// チーズケーキ抹茶
$priceCheeseMaccha_S = 1000;
$priceCheeseMaccha_M = 2000;
$priceCheeseMaccha_L = 3000;


// 商品名
if($genre === '1') {
  $name = 'チーズケーキ -プレーン-';
} elseif($genre === '2') {
  $name = 'チーズケーキ -抹茶-';
} else {
}

// 価格 プレーン
if($genre === '1' && $size === '12cm') {
  $price = $priceCheesePlane_S;
} elseif($genre === '1' && $size === '15cm') {
  $price = $priceCheesePlane_M;
} elseif($genre === '1' && $size === '18cm') {
  $price = $priceCheesePlane_L;
} else {
}
// 価格 抹茶
if($genre === '2' && $size === '12cm') {
  $price = $priceCheeseMaccha_S;
} elseif($genre === '2' && $size === '15cm') {
  $price = $priceCheeseMaccha_M;
} elseif($genre === '2' && $size === '18cm') {
  $price = $priceCheeseMaccha_L;
} else {
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="keyword" content="u-cafe,熊本カフェ,熊本パフェ">
  <meta name="description" content="あなたとわたしのカフェ。U-cafe。山小屋をイメージした木のぬくもりが温かい空間で、元パティシエがつくる洗練された料理をあなたに。">
  <meta name="robots" content="noindex,nofollow">
  <title>買い物カート | shop -オンラインショップ- | U-cafe 【公式】あなたとわたしのカフェ。</title>
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
  <header class="header-photo">
    <div class="header_under mb_50">
      <div class="inner">
        <!-- ヘッダーナビ -->
        <div class="nav nav-border">
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
              <li><a class="hov_nav_b" href="contact.html">CONTACT</a></li>
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
    <div class="shop-ti-big d-f ai-c jc-c bl fadeUpTrigger">
      <p class="shop-ti-big-p">SHOPPING CART / U-cafe</p>
    </div>
    <div class="inner">
      <div class="cart_a fadeUpTrigger">
        <div class="cart_b">
          <ul class="d-f">
            <li>料金</li>
            <li>数量</li>
            <li>合計</li>
          </ul>
        </div>
        <div class="cart_item d-f js-sb">
          <img src="img/kari/cookie.jpg" alt="カート写真">
          <div class="cart_e">
            <p class="cart_1"><?php echo $name; ?></p>
            <p class="cart_2">SIZE：<?php echo $size; ?></p>
            <div class="cart_3">削除する</div>
          </div>
          <div class="cart_e-0 d-f">
            <div class="cart_e-1 cc1">2,000円</div>
            <div class="cart_e-2 cc1">○個</div>
            <div class="cart_e-3 cc1">○○○円</div>
          </div>
        </div>
        <!-- /.cart_item -->
        <div class="cart_atr d-f js-sb">

          <div class="cart_k mt_50">
            <p class="cart_f">＊ご要望 / ご贈答用にお熨斗をご希望のかたはこちらへご記入ください。</p>
            <div class="cart_g"></div>
          </div>

          <div class="cart_j d-f fd-c ai-c">
            <div class="cart_h d-f ai-fe js-sb mt_50">
              <div class="cart_7">
                <p>お支払い金額<br>（お引渡し時）</p>
              </div>
              <div class="cart_8">2,000円</div>
            </div>
            <div class="cart_i">
              <div class="btn-6 ww">
                <a href="#">ご購入</a>
              </div>
              <div class="btn-7 ww">
                <a href="#">買い物を続ける</a>
              </div>
            </div>

          </div>
        </div>
        <!-- /.cart_atr -->
      </div>
      <!-- /.cart_a -->
    </div>
    <!-- /.inner -->
  </main>
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