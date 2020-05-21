<?php
session_start();
include("../includes/header.php");
include("../includes/menu.php");
include("../includes/footer.php");
$mysqli = mysqli_connect("localhost", "minishop", "minishop", "minidb");
if(isset($_GET['fail'])){
  echo '<h1 class="Error_Msg">Mauvais ID ou password</h1>';
}
if (isset($_POST['pseudo']) && isset($_POST['password']))
{
  $pseudo = htmlspecialchars($_POST['pseudo']);
  $password = hash('whirlpool', $_POST['password']);
  $tmp = 0;
  $log = 0;
  $res = mysqli_query($mysqli, "SELECT IdUser FROM `user` WHERE Username='$pseudo' AND Password='$password'");
  if ($cat = mysqli_fetch_array($res)) {
      $IdUser = $cat["IdUser"];
      $_SESSION['IdUser'] = $IdUser;
      $log = 1;
    }
  if($log == 0){
    $_SESSION['log'] = 0;
    header('location: ../php/connexion.php?fail=1');
  }
  else{
    $_SESSION['log'] = 1;
    $_SESSION['user'] = $pseudo;
    $_SESSION['password'] = $password;
    if ($_SESSION['user'] == 'admin')
	{
		$_SESSION['admin'] = 1;
		header('location: ../php/admin.php');
	}
    else{
		$_SESSION['admin'] = 0;
		header('location: ../index.php');
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
      <form method="post" action="connexion.php">
      <label class="labelForm" for="uname">Pseudo</label>
      <input type="text" class="inputForm" placeholder="Enter Pseudo" name="pseudo" required>
      <label class="labelForm" for="psw">Password</label>
      <input type="password" class="inputForm" placeholder="Enter Password" name="password" id="password" required>
      <button type="submit" value="Connexion" class="btnForm">Login</button>
    </form>
    </div>
  </div>
</body>
</html>
