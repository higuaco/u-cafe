<?php

$number = $_POST['number'];
echo $number;

$size = $_POST['size'];
echo $size;

$genre = $_POST['genre'];
echo $genre;

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
?>