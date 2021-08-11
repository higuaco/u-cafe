<?php
    $delete_name = isset($_POST['delete_name'])? htmlspecialchars($_POST['delete_name'], ENT_QUOTES, 'utf-8') : '';
    session_start();

    if($delete_name != '') unset($_SESSION['uProducts'][$delete_name]);

    $uProducts = isset($_SESSION['uProducts'])? $_SESSION['uProducts']:[];

    $total = 0;
    $priceCheesePlane_S = 1000;
    $priceCheesePlane_M = 2000;
    $priceCheesePlane_L = 3000;
    $priceCheeseMaccha_S = 1000;
    $priceCheeseMaccha_M = 2000;
    $priceCheeseMaccha_L = 3000;

    if(isset($uProducts)){
          foreach($uProducts as $cakeName => $uProduct){
            if($cakeName==='チーズケーキ -抹茶-' && $uProduct['size'] === '12cm'){
              $price = $priceCheeseMaccha_S;
              $subtotal = $price*$uProduct['number'];
            } elseif($cakeName==='チーズケーキ -抹茶-' && $uProduct['size'] === '15cm') {
              $price = $priceCheeseMaccha_M;
              $subtotal = $price*$uProduct['number'];
            } elseif($cakeName==='チーズケーキ -抹茶-' && $uProduct['size'] === '18cm'){
              $price = $priceCheeseMaccha_L;
              $subtotal = $price*$uProduct['number'];
            } elseif($cakeName==='チーズケーキ -プレーン-' && $uProduct['size'] === '12cm'){
              $price = $priceCheesePlane_S;
              $subtotal = $price*$uProduct['number'];
            } elseif($cakeName==='チーズケーキ -プレーン-' && $uProduct['size'] === '15cm'){
              $price = $priceCheesePlane_M;
              $subtotal = $price*$uProduct['number'];
            } elseif($cakeName==='チーズケーキ -プレーン-' && $uProduct['size'] === '18cm'){
              $price = $priceCheesePlane_L;
              $subtotal = $price*$uProduct['number'];
            }

            $total += $subtotal;
              // echo $cakeName;      //商品名
              // echo "<br>";
              // echo $uProduct['number'];  //商品の個数
              // echo "<br>";
              // echo $uProduct['size']; //商品の金額
              // echo "<br>";
          }
      }
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="keyword" content="u-cafe,熊本カフェ,熊本パフェ">
  <meta name="description" content="あなたとわたしのカフェ。U-cafe。山小屋をイメージした木のぬくもりが温かい空間で、元パティシエがつくる洗練された料理をあなたに。">
  <meta name="robots" content="noindex,nofollow">
  <title>カート | U-cafe 【公式】あなたとわたしのカフェ。</title>
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
    <div class="shop-ti-big d-f ai-c jc-c fadeUpTrigger">
      <p class="shop-ti-big-p">SHOPPING CART / U-cafe</p>
    </div>
    <div class="inner">

      <div class="cartlist mt_50">
        <table class="cart-table">
          <thead>
            <tr>
              <th>商品名</th>
              <th>価格</th>
              <th>個数</th>
              <th>小計</th>
              <th>操作</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($uProducts as $cakeName => $uProduct): ?>
            <tr>
              <td class="ta-l" label="商品名："><?php echo $cakeName; ?>　　<?php echo $uProduct['size']; ?></td>
              <td label="価格：" class="text-right">&yen;<?php echo $price; ?></td>
              <td label="個数：" class="text-right"><?php echo $uProduct['number']; ?></td>
              <td label="小計：" class="text-right">&yen;<?php echo $subtotal; ?></td>
              <td>
                <form action="cart.php" method="post">
                  <input type="hidden" name="delete_name" value="<?php echo $cakeName; ?>">
                  <button type="submit" class="btn btn-red">削除</button>
                </form>
            </tr>
            <?php endforeach; ?>
            <tr class="total">
              <th colspan="3">合計</th>
              <td colspan="2">&yen;<?php echo $total ?></td>
            </tr>
          </tbody>
        </table>
        <div class="cart-btn mt_50">
          <button type="button" class="btn btn-blue" onclick="location.href='pay.php'"
            <?php if(empty($uProducts)) echo 'disabled="disabled"'; ?>>購入手続きへ</button>
          <button type="button" class="btn btn-gray" onclick="location.href='shop.html'">お買い物を続ける</button>
        </div>
      </div>



    </div>
  </main>
  <footer class="fadeUpTrigger mt_100">
    <small>Copyright &copy Sheepontaneous,All rights reserved.</small>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  <script src="script.js"></script>
</body>

</html>