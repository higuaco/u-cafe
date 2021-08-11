<?php
  $id = $_POST['loginId'];
  echo $id;
  $pass = $_POST['loginPass'];
  echo $pass;

  if($id==='ucafe' && $pass==='123') {
  ?>
<form action="check.php" method="POST">
  <label for="日付">日付</label>

</form>

<?php
}
?>