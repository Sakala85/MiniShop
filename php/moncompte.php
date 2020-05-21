
<?php
session_start();
include("../includes/header.php");
include("../includes/menu.php");
include("../includes/footer.php");
$mysqli = mysqli_connect("localhost", "minishop", "minishop", "minidb");

?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>minishop</title>
  </head>
  <body>
    <h1>Mes commandes</h1>
	<div class="group_item_vendu">
    <?php
    $IdUser = htmlspecialchars($_SESSION['IdUser']);
    $res = mysqli_query($mysqli, "SELECT * FROM `sales` WHERE IdUser='$IdUser'");
    while ($cat = mysqli_fetch_array($res)) {
      if ($cat["Number"] > 0)
	  ?>
      <?php
		if ($cat["Number"] > 0)
			echo "<div class=\"item_vendu\">
	          <p>Name : ".$cat["Name"]."    Price : ".$cat["Price"]."    Quantit&eacutee : ".$cat["Number"]."</p>
	        </div>";
		?>
      <?php
    }

     ?>
 </div>
	 <div class="Form_account">
     <h2>Change Password ?</h2>
	 <form class="" action="../php/changepwd.php" method="post">
       <input type="submit" value="Change Password">
     </form>
	 <h2>Delete Account ?</h2>
	 <form class="" action="../php/deleteaccount.php" method="post">
       <input type="submit" value="Delete Account">
     </form>
 	</div>
  </body>
</html>
