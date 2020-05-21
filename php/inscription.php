<?php
session_start();
include("../includes/header.php");
include("../includes/menu.php");
include("../includes/footer.php");
$mysqli = mysqli_connect("localhost", "minishop", "minishop", "minidb");
if(isset($_GET['fail']) && $_GET['fail'] == 1){
  echo '<h1 class="Error_Msg">Ce pseudo ou ce mail est déjà utilisé</h1>';
}
else if(isset($_GET['fail']) && $_GET['fail'] == 3){
  echo '<h1 class="Error_Msg">Entrez un pseudo valide.</h1>';
}
if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['adress']))
{
  if ($_POST['pseudo'] !== htmlspecialchars($_POST['pseudo'])){
    header('location: ../php/inscription.php?fail=3');
  }
  else{
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $password = hash('whirlpool', $_POST['password']);
  $email = htmlspecialchars($_POST['email']);
  $adress = htmlspecialchars($_POST['adress']);

  $res = mysqli_query($mysqli, "SELECT * FROM `user` WHERE Username='$pseudo' OR Mail='$email'");
  $i = 0;
  while (mysqli_fetch_array($res)) {
        $i = 1;
    }
  if ($i == 0)
  {
    mysqli_query($mysqli, "INSERT INTO `user` (`Username`, `Password`, `Mail`, `Address`) VALUES ('$pseudo', '$password', '$email', '$adress')");
    $_SESSION['log'] = 1;
    $_SESSION['user'] = $pseudo;
    $_SESSION['password'] = $password;
    $findID = mysqli_query($mysqli, "SELECT IdUser FROM `user` WHERE Username='$pseudo' OR Mail='$email'");
    $cat = mysqli_fetch_array($findID);
    $_SESSION['IdUser'] = $cat["IdUser"];
    header('location: ../index.php');
  }
  else{
    $_SESSION['log'] = 0;
    header('location: ../php/inscription.php?fail=1');
    }
  }
}

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../css/siteStyle.css">
</head>
<body>
<div class="from_group">
<div class="form_page">
<form action="inscription.php" method="post">
    <label for="pseudo" class="labelForm">Pseudo</label>
    <input type="text" class="inputForm" placeholder="Enter Username" name="pseudo" id="pseudo" required>
    <label for="password" class="labelForm">Password</label>
    <input type="password" class="inputForm" placeholder="Enter Password" name="password" id="password" required>
    <label for="email" class="labelForm">Email</label>
    <input type="email" placeholder="Enter Email" name="email" id="email" class="inputForm" required>
    <label for="Adress" class="labelForm">Adress</label>
    <input type="text" placeholder="Enter Adress" name="adress" id="email" class="inputForm" required>
    <button type="submit" class="btnForm">Register</button>
</form>
</div>
</div>

</body>
</html>
