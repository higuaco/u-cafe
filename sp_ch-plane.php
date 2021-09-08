<?php

// $genre = isset($_POST['genre'])? htmlspecialchars($_POST['genre'], ENT_QUOTES, 'utf-8') : '';
// echo $genre;

$cakeName = isset($_POST['cakeName'])? htmlspecialchars($_POST['cakeName'], ENT_QUOTES, 'utf-8') : '';
// echo $cakeName;

$size = isset($_POST['size'])? htmlspecialchars($_POST['size'], ENT_QUOTES, 'utf-8') : '';
// echo $size;

$number = isset($_POST['number'])? htmlspecialchars($_POST['number'], ENT_QUOTES, 'utf-8') : '';
// echo $number;

session_start();

//もし、sessionにproductsがあったら
if(isset($_SESSION['uProducts'])){
//$_SESSION['products']を$productsという変数にいれる
$uProducts = $_SESSION['uProducts'];
//$productsをforeachで回し、キー(商品名)と値（金額・個数）取得
foreach($uProducts as $key => $uProduct){
//もし、キーとPOSTで受け取った商品名が一致したら、
if($key == $cakeName && $size == $uProduct['size']){
//既に商品がカートに入っているので、個数を足し算する
$number = (int)$number + (int)$uProduct['number'];
}
}
}
//配列に入れるには、$name,$count,$priceの値が取得できていることが前提なのでif文で空のデータを排除する
if($cakeName!=''&&$number!=''&&$size!=''){
$_SESSION['uProducts'][$cakeName]=[
'number' => $number,
'size' => $size
];
}
$uProducts = isset($_SESSION['uProducts'])? $_SESSION['uProducts']:[];

// if(isset($uProducts)){
// foreach($uProducts as $key => $uProduct){
// echo $key; //商品名
// echo "<br>";
// echo $uProduct['number']; //商品の個数
// echo "<br>";
// echo $uProduct['size']; //商品の金額
// echo "<br>";
// }
// }


?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="keyword" content="u-cafe,熊本カフェ,熊本パフェ">
  <meta name="description" content="あなたとわたしのカフェ。U-cafe。山小屋をイメージした木のぬくもりが温かい空間で、元パティシエがつくる洗練された料理をあなたに。">
  <meta name="robots" content="noindex,nofollow">
  <title>プレーン-チーズケーキ | U-cafe 【公式】あなたとわたしのカフェ。</title>
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
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
  <!-- headerー -->
  <header>
    <div class="header_under_index header_under_index-bk mb_50">
      <!-- nav -->
      <div class="nav bg_w">
        <h1><a class="hov" href="/"><img src="img/u-cafe-logo_black.png" alt="黒ロゴ。u-cafe.あなたとわたしのカフェ。| 熊本市東区"></a></h1>
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
  </header>
  <main>
    <div class="shop-ti-big d-f ai-c jc-c fadeUpTrigger">
      <p class="shop-ti-big-p">ONLINE SHOP / U-cafe</p>
    </div>
    <div class="inner">



      <div class="sp-dt-main d-f js-sb">
        <div class="sp-dt-sub1 fadeUpTrigger">
          <ul class="gallery2">
            <li><img src="img/kari/d1.jpg" alt="チーズケーキの写真"></li>
            <li><img src="img/kari/d2.jpg" alt="チーズケーキの写真"></li>
            <li><img src="img/kari/d3.jpg" alt="チーズケーキの写真"></li>
          </ul>
          <ul class="choice-btn">
            <li><img src="img/kari/d1.jpg" alt="チーズケーキの写真"></li>
            <li><img src="img/kari/d2.jpg" alt="チーズケーキの写真"></li>
            <li><img src="img/kari/d3.jpg" alt="チーズケーキの写真"></li>
          </ul>
        </div>
        <!-- /.sp-dt-sub1 -->
        <div class="sp-dt-sub2 d ta-l fadeUpTrigger">
          <p class="sp-dt-name">CHEESECAKE -PLANE-</p>
          <p class="sp-dt-name2">チーズケーキ -プレーン-</p>
          <!-- Price Section -->
          <div class="dt-price d-f">
            <p>価格：</p>
            <!-- Section -->
            <div class="c-m_s section">
              <p>1,000円（税込）</p>
            </div>
            <div class="c-m_m section">
              <p>2,000円（税込）</p>
            </div>
            <div class="c-m_l section">
              <p>3,000円（税込）</p>
            </div>
          </div>

          <div class="dt-size d-f">
            <div class="dt-size-ti">
              <p>SIZE</p>
            </div>
            <!-- <div class="dt-size-po">
              <p>&#92;&nbsp;一番人気&nbsp;/</p>
            </div> -->
          </div>
          <div class="dt-size-dt d-f">
            <!-- List -->
            <div>
              <button id="c-m_s" class="secList dt-size" value="12cm" name="size" onclick="buy_s();">12cm</button>
            </div>
            <div>
              <button id="c-m_m" class="secList dt-size" value="15cm" name="size" onclick="buy_m();">15cm</button>
            </div>
            <div>
              <button id="c-m_l" class="secList dt-size" value="18cm" name="size" onclick="buy_l();">18cm</button>
            </div>
          </div>

          <div class="dt-size d-f">
            <div class="dt-size-ti">
              <p>個数</p>
            </div>
          </div>
          <!-- form -->
          <form method="POST">
            <input class="sp_number" type="text" required="required" value="1" name="number">

            <div class="dt-text">
              <p>
                無添加の材料で作る、濃厚なチーズケーキ。<br>
                甘さを控えめに作っておりますので、幅広い年齢に好評です。<br>
                お好みでブルーベリージャムなどをつけていただくと、より一層美味しく召し上がれます。
              </p>
            </div>
        </div>
        <!-- /.sp-dt-sub2 -->
      </div>
      <!-- /.sp-dt-maim -->
      <input type="hidden" name="size" value="" id="size2">
      <!-- <input type="hidden" name="genre" value="2"> -->
      <input type="hidden" name="cakeName" value="チーズケーキ -プレーン-">
      <button type="submit" class="btn-6 fadeUpTrigger" id="sub" onclick="return buy();">
        <span>カートに入れる</span>
      </button>
      <button type="button" class="btn-6 d-ib fadeUpTrigger" onclick="location.href='cart.php'"
        <?php if(empty($uProducts)) echo 'disabled="disabled"'; ?>>
        <span>カートを見る</span>
      </button>
      </form>

      <div class="btn-7 fadeUpTrigger">
        <a href="shop.html">戻る</a>
      </div>
    </div>
    <!-- /.inner -->
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
  <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script src="script.js"></script>
  <script>
  function buy_s() {
    var s = document.getElementById('c-m_s');
    var m = document.getElementById('c-m_m');
    var l = document.getElementById('c-m_l');
    var size = s.value;
    document.getElementById("sub").value = size;
    document.getElementById("size2").value = size;
    s.style.backgroundColor = "#bfcdcc";
    m.style.backgroundColor = "#fff";
    l.style.backgroundColor = "#fff";
    s.style.color = "#fff";
    m.style.color = "#000";
    l.style.color = "#000";
  }

  function buy_m() {
    var s = document.getElementById('c-m_s');
    var m = document.getElementById('c-m_m');
    var l = document.getElementById('c-m_l');
    var size = m.value;
    document.getElementById("sub").value = size;
    document.getElementById("size2").value = size;
    s.style.backgroundColor = "#fff";
    m.style.backgroundColor = "#bfcdcc";
    l.style.backgroundColor = "#fff";
    s.style.color = "#000";
    m.style.color = "#fff";
    l.style.color = "#000";
  }

  function buy_l() {
    var s = document.getElementById('c-m_s');
    var m = document.getElementById('c-m_m');
    var l = document.getElementById('c-m_l');
    var size = l.value;
    document.getElementById("sub").value = size;
    document.getElementById("size2").value = size;
    s.style.backgroundColor = "#fff";
    m.style.backgroundColor = "#fff";
    l.style.backgroundColor = "#bfcdcc";
    s.style.color = "#000";
    m.style.color = "#000";
    l.style.color = "#fff";
  }

  function buy() {
    var size = document.getElementById('sub');
    if (size.value == "") {
      alert("サイズを選択してください");
      return false;
    } else {
      return true;
    }

  }
  </script>
</body>

</html>