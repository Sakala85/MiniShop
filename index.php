<?php
session_start();
include("./includes/header.php");
include("./includes/menu.php");
include("./includes/footer.php");
$mysqli = mysqli_connect("localhost", "minishop", "minishop", "minidb");
//___________________Ajout des articles via les Cookies ___________________//
if (isset($_POST['size']) && isset($_POST['product']))
{
  $IdProduct = htmlspecialchars($_POST['product']);
  $Size = htmlspecialchars($_POST['size']);
  //________________On recupere l'ID du Stock, on enleve le Stock et cree le cookie______________//
  $result = mysqli_query($mysqli, "SELECT Stock.IdStock AS IdStock, Stock.Stock AS Stock
    FROM stock
    JOIN product ON product.IdProduct = stock.IdProduct
    WHERE stock.Size = '$Size' AND product.IdProduct = $IdProduct");
    while($IdTab = mysqli_fetch_array($result))
    {
      $IdStock = $IdTab['IdStock'];
      $Stock = $IdTab['Stock'] - 1;
    }
    mysqli_query($mysqli, "UPDATE `stock` SET Stock='$Stock' WHERE IdStock='$IdStock'");
    if (!isset($_SESSION['basket'][$IdStock]))
      $_SESSION['basket'][$IdStock] = array("stock" => 1);
    else
      $_SESSION['basket'][$IdStock]['stock']++;
}
//_______________________On verifie si on a GET une category_______________//
if (isset($_GET['category']))
{
  $category = htmlspecialchars($_GET['category']);
  if ($category !== $_GET['category'])
  {
    header('location: ./index.php');
  }
}
if (isset($_GET['brand']))
{
  $brand = htmlspecialchars($_GET['brand']);
}
//___________________________Si on a une category on sors seulement la category sinon tout_____________//
if (isset($category)){
  $res = mysqli_query($mysqli, "SELECT product.IdProduct AS IdProduct, product.Name AS Name, product.Price AS Price, product.Picture AS Picture
    FROM product
    JOIN category ON product.IdCategory = category.IdCategory
    WHERE category.Name = '$category'");
}
else if (isset($brand)){
  $res = mysqli_query($mysqli, "SELECT product.IdProduct AS IdProduct, product.Name AS Name, product.Price AS Price, product.Picture AS Picture
    FROM product
    JOIN brand ON product.IdBrand = brand.IdBrand
    WHERE brand.Name = '$brand'");
}
else{
  $res = mysqli_query($mysqli, "SELECT IdProduct, Name, Price, Picture FROM `product`");
}

 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/siteStyle.css">
    <title>minishop</title>
  </head>
  <body>
    <h1>Bienvenue sur Minishop !</h1>
    <div class="group_item">
      <?php
      //___________________On fetch la requete SQL pour afficher tous les articles________________//
      while ($cat = mysqli_fetch_array($res)) {
        $IdProduct = $cat["IdProduct"];
        $res_stock = mysqli_query($mysqli, "SELECT Size FROM `Stock` WHERE IdProduct='$IdProduct' AND Stock>'0' GROUP BY Size");
            ?>
            <div class="item_existant">
              <h2 class="item_content"><?php echo $cat["Name"]; ?></h2>
              <img class="item_img" src="./img/<?php echo $cat["Picture"]; ?>" >
              <h3 class="item_content"><?php echo $cat["Price"] ?> $</h3>
              <form action="index.php" method="post">
                <select name="size">
                  <?php
                  //___________________On fetch la requete des stocks pour voir ce qu'il nous reste___________//
                  while($catStock = mysqli_fetch_array($res_stock))
                  {
                    ?> <option value="<?php echo $catStock["Size"]; ?>"><?php echo $catStock["Size"]; ?></option> <?php
                  }
                   ?>
                 </select>
                <input type="hidden" value="<?php echo $IdProduct; ?>" name="product">
                <input type="submit" class="button_art" value="+">
              </form>
            </div>
            <?php
        }
    ?>
    </div>
  </body>
</html>
