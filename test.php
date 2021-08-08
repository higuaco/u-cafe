<?php

$genre = isset($_POST['genre'])? htmlspecialchars($_POST['genre'], ENT_QUOTES, 'utf-8') : '';
// echo $genre;

$size = isset($_POST['size'])? htmlspecialchars($_POST['size'], ENT_QUOTES, 'utf-8') : '';
// echo $size;

$number = isset($_POST['number'])? htmlspecialchars($_POST['number'], ENT_QUOTES, 'utf-8') : '';
// echo $number;

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
echo $price;
echo $name;


echo $cakeName;
echo "<br>";
echo $uProduct['number'];
echo "<br>";
echo $uProduct['size'];
?>

foreach ($uProducts as $cakeName => $uProduct) {
// 価格
if ($cakeName === 'チーズケーキ -プレーン-' && $uProduct['size'] === '12cm') {
$price = $priceCheesePlane_S;
$subtotal = (int)$priceCheesePlane_S*(int)$uProduct['number'];
} elseif ($cakeName === 'チーズケーキ -プレーン-' && $uProduct['size'] === '15cm') {
$price = $priceCheesePlane_M;
$subtotal = (int)$priceCheesePlane_M*(int)$uProduct['number'];
} elseif ($cakeName === 'チーズケーキ -プレーン-' && $uProduct['size'] === '18cm') {
$price = $priceCheesePlane_L;
$subtotal = (int)$priceCheesePlane_L*(int)$uProduct['number'];
} elseif ($cakeName === 'チーズケーキ -抹茶-' && $uProduct['size'] === '12cm') {
$price = $priceCheeseMaccha_S;
$subtotal = (int)$priceCheeseMaccha_S*(int)$uProduct['number'];
} elseif ($cakeName === 'チーズケーキ -抹茶-' && $uProduct['size'] === '15cm') {
$price = $priceCheeseMaccha_M;
$subtotal = (int)$priceCheeseMaccha_M*(int)$uProduct['number'];
} elseif ($cakeName === 'チーズケーキ -抹茶-' && $uProduct['size'] === '18cm') {
$price = $priceCheeseMaccha_L;
$subtotal = (int)$priceCheeseMaccha_M*(int)$uProduct['number'];
} else {
}
//各商品の小計を$totalに足す
$total += $subtotal;
}