<?php
  session_start();
  $mysqli = mysqli_connect("localhost", "minishop", "minishop", "minidb");
  foreach ($_SESSION['basket'] as $IdStock => $i) {
    foreach( $i as $cle=> $nbr_article )
    {
      $res = mysqli_query($mysqli, "SELECT product.Name AS Name, product.Price AS Price
         FROM `product` JOIN `stock`
         WHERE stock.IdStock = $IdStock AND product.IdProduct = stock.IdProduct");
      while ($cat = mysqli_fetch_array($res)){
        $Name = $cat["Name"];
        $Price = $cat["Price"];
        $IdUser = htmlspecialchars($_SESSION['IdUser']);
        mysqli_query($mysqli, "INSERT INTO `sales` (`IdStock`, `IdUser`, `Number`, `Price`, `Name`) VALUES ('$IdStock', '$IdUser', '$nbr_article', '$Price', '$Name')");
    }
  }
}
  unset($_SESSION['basket']);
  header('location: ../php/moncompte.php');
 ?>
