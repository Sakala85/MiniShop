<?php
  session_start();
  include("../includes/header.php");
  include("../includes/menu.php");
  include("../includes/footer.php");
  $mysqli = mysqli_connect("localhost", "minishop", "minishop", "minidb");
  if (isset($_POST['stock']) && isset($_POST['IdStock']))
  {
    $Stock = $_POST['stock'] + 1;
    $Stock = htmlspecialchars($Stock);
    $IdStock = htmlspecialchars($_POST['IdStock']);
    if ($_SESSION['basket'][$IdStock]['stock'] > 0)
    {
    mysqli_query($mysqli, "UPDATE `stock` SET Stock='$Stock' WHERE IdStock='$IdStock'");
    $_SESSION['basket'][$IdStock]['stock']--;
  }
}
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/siteStyle.css">
    <title>minishop</title>
  </head>
  <body>
    <h1>Bienvenue sur Votre Panier !</h1>
    <div class="group_item">
<?php
  $FinalPrice = 0;
  foreach ($_SESSION['basket'] as $IdStock => $i) {
    foreach( $i as $cle=> $nbr_article )
    {
      $res = mysqli_query($mysqli, "SELECT product.Name AS Name, product.Price AS Price, product.Picture AS Picture, stock.Stock AS Stock
        FROM `product` JOIN `stock`
        WHERE stock.IdStock = $IdStock AND product.IdProduct = stock.IdProduct");
      while ($cat = mysqli_fetch_array($res)){
        if ($_SESSION['basket'][$IdStock]['stock'] > 0)
        {
        ?>
        <div class="item_existant">
          <h2 class="item_content"><?php echo $cat["Name"]; ?></h2>
          <img class="item_img" src="../img/<?php echo $cat["Picture"]; ?>" >
          <h3 class="item_content"><?php echo $cat["Price"] ?> $</h3>
          <?php echo $nbr_article; ?>
          <form action="panier.php" method="post">
            <input type="hidden" value="<?php echo $cat["Stock"]; ?>" name="stock">
            <input type="hidden" value="<?php echo $IdStock; ?>" name="IdStock">
            <input type="submit" class="button_art" value="-">
          </form>
        </div>
		</div>
        <?php
        //_________On ajuste le panier final________________//
        $FinalPrice = $FinalPrice + ($cat["Price"] * $nbr_article);
      }
      }
    }
  }
  ?>  <div class="Form_account"> <?php
  echo "<h2>Panier Final : ".$FinalPrice." $</h2>";
  if($_SESSION['log'] === 0){
    ?><button><a class="button" href="../php/connexion.php">Connectez-vous pour valider votre panier</a></button>
    <?php
  }
  else{
    ?>
    <form class="" action="../php/validation.php" method="post">
      <input type="submit" value="Valider le Panier">
    </form><?php
  }
 ?>
</div>

  </body>
</html>
<?php
//___________________On fetch la requete SQL pour afficher tous les articles________________//
