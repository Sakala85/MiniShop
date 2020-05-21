<?php
session_start();
include("../includes/header.php");
include("../includes/menu.php");
include("../includes/footer.php");
$mysqli = mysqli_connect("localhost", "minishop", "minishop", "minidb");
if(isset($_GET['fail'])){
  echo '<h1>Mauvais mot de passe</h1>';
}
if (isset($_POST['oldpwd']) && isset($_POST['newpwd']) && isset($_SESSION['user']))
{
  $oldpwd = hash('whirlpool', $_POST['oldpwd']);
  $newpwd = hash('whirlpool', $_POST['newpwd']);
  $sessID = $_SESSION['user'];
  $log = 0;
  $res = mysqli_query($mysqli, "SELECT * FROM `user` WHERE Username='$sessID' AND Password='$oldpwd'");
  while (mysqli_fetch_array($res)) {
        $log = 1;
    }
  if($log == 0){
    header('location: ../php/changepwd.php?fail=1');
  }
  else{
    mysqli_query($mysqli, "UPDATE `user` SET Password='$newpwd' WHERE Username='$sessID'");
    $_SESSION['password'] = $newpwd;
    header('location: ../index.php');
  }
}

 ?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/siteStyle.css">
</head>
<body>
  <div class="form_page">
      <form method="post" action="changepwd.php">
      <label class="labelForm" for="uname">Ancien Mot de passe</label>
      <input type="password" class="inputForm" name="oldpwd" required>
      <label class="labelForm" for="psw">Nouveau Mot de Passe</label>
      <input type="password" class="inputForm" name="newpwd" required>
      <button type="submit" value="Connexion" class="btnForm">Login</button>
    </form>
  </div>
</body>
</html>
