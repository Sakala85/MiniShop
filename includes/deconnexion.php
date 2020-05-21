<?php
session_start();
session_destroy();
$titre="Déconnexion";
include("../includes/header.php");
include("../includes/menu.php");
include("../includes/footer.php");
session_start();
if(isset($_SESSION['log'])){
  $_SESSION['log'] = 0;
  $_SESSION['user'] = NULL;
  $_SESSION['password'] = NULL;
  $_SESSION['IdUser'] = NULL;
  $_SESSION['admin'] = NULL;
}
header('location: ../index.php');
?>
