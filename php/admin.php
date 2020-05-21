<?php
session_start();
include("../includes/header.php");
include("../includes/menu.php");
include("../includes/footer.php");

$mysqli = mysqli_connect("localhost", "minishop", "minishop", "minidb");
$pass = $_SESSION['password'];
$user = htmlspecialchars($_SESSION['user']);
$res = mysqli_query($mysqli, "SELECT * FROM `user` WHERE Username='$user' AND Password='$pass'");
if (!mysqli_num_rows($res) || $_SESSION['user'] !== 'admin' || $_SESSION['admin'] != 1)
{
    echo "<p style='text-align:center'><b>Unauthorized page !</b></p><br />";
	header('location: ../index.php');
}
else{
// ______________________________ModifCategory________________________________//
//__________________________________DELETE____________________________________//
	if (isset($_POST['deleteCategory']))
	{
		$tmp = htmlspecialchars($_POST['category']);
		mysqli_query($mysqli, "DELETE FROM `category` WHERE Name='$tmp'");
	}
//___________________________________MODIFY___________________________________//
	if (isset($_POST['changeCategory']) && isset($_POST['ChangeOrAddCategory']))
	{
		$name = htmlspecialchars($_POST['category']);
		$new_name = htmlspecialchars($_POST['ChangeOrAddCategory']);
		$tmp = mysqli_fetch_array(mysqli_query($mysqli, "SELECT `Name` FROM `category` WHERE Name='$new_name'"));
		if (!isset($tmp["Name"]))
			mysqli_query($mysqli, "UPDATE `category` SET Name='$new_name' WHERE Name='$name'");
	}
//_____________________________________ADD____________________________________//
	if (isset($_POST['addCategory']) && isset($_POST['ChangeOrAddCategory']))
	{
		$new_name = htmlspecialchars($_POST['ChangeOrAddCategory']);
		$tmp = mysqli_fetch_array(mysqli_query($mysqli, "SELECT `Name` FROM `category` WHERE Name='$new_name'"));
		if (!isset($tmp["Name"]))
			mysqli_query($mysqli, "INSERT INTO `category` (`Name`) VALUES ('$new_name')");
	}

// ________________________________ModifBrand_________________________________//
//__________________________________DELETE____________________________________//
	if (isset($_POST['deleteBrand']))
	{
		$tmp = htmlspecialchars($_POST['brand']);
		mysqli_query($mysqli, "DELETE FROM `brand` WHERE Name='$tmp'");
	}
//___________________________________MODIFY___________________________________//
	if (isset($_POST['changeBrand']) && isset($_POST['ChangeOrAddBrand']))
	{
		$name = htmlspecialchars($_POST['brand']);
		$new_name = htmlspecialchars($_POST['ChangeOrAddBrand']);
		$tmp = mysqli_fetch_array(mysqli_query($mysqli, "SELECT `Name` FROM `brand` WHERE Name='$new_name'"));
		if (!isset($tmp["Name"]))
			mysqli_query($mysqli, "UPDATE `brand` SET Name='$new_name' WHERE Name='$name'");
	}
//_____________________________________ADD____________________________________//
	if (isset($_POST['addBrand']) && isset($_POST['ChangeOrAddBrand']))
	{
		$new_name = htmlspecialchars($_POST['ChangeOrAddBrand']);
		$tmp = mysqli_fetch_array(mysqli_query($mysqli, "SELECT `Name` FROM `brand` WHERE Name='$new_name'"));
		if (!isset($tmp["Name"]))
			mysqli_query($mysqli, "INSERT INTO `brand` (`Name`) VALUES ('$new_name')");
	}


// _______________________________ModifProduct________________________________//


//__________________________________DELETE____________________________________//
	if (isset($_POST['deleteProduct']))
	{
		$tmp = htmlspecialchars($_POST['product']);
		mysqli_query($mysqli, "DELETE FROM `product` WHERE Name='$tmp'");
	}

//___________________________________MODIFY___________________________________//
	if (isset($_POST['changeProduct']))
	{
		$name = htmlspecialchars($_POST['product']);
		if ($_POST['ChangeOrAddProductName'] != NULL)
		{
			$new_name = htmlspecialchars($_POST['ChangeOrAddProductName']);
			$tmp = mysqli_fetch_array(mysqli_query($mysqli, "SELECT `Name` FROM `product` WHERE Name='$new_name'"));
			if (!isset($tmp["Name"]))
			{
				mysqli_query($mysqli, "UPDATE `product` SET Name='$new_name' WHERE Name='$name'");
				$name = $new_name;
			}
		}
		if ($_POST['ChangeOrAddProductPrice'] != NULL)
		{
			$new_price = htmlspecialchars($_POST['ChangeOrAddProductPrice']);
			mysqli_query($mysqli, "UPDATE `product` SET Price='$new_price' WHERE Name='$name'");
		}
		if ($_POST['ChangeOrAddProductPicture'] != NULL)
		{
			$new_picture = htmlspecialchars($_POST['ChangeOrAddProductPicture']);
			mysqli_query($mysqli, "UPDATE `product` SET Picture='$new_picture' WHERE Name='$name'");
		}
		$category = htmlspecialchars($_POST['productCat']);
		$brand = htmlspecialchars($_POST['productBrand']);

		$tmp_cat = mysqli_query($mysqli, "SELECT `IdCategory` FROM `Category` WHERE Name='$category'");
		$tmp = mysqli_fetch_array($tmp_cat);
		if (isset($tmp["IdCategory"]))
		{
			$new_cat = $tmp['IdCategory'];
		 	mysqli_query($mysqli, "UPDATE `product` SET IdCategory='$new_cat' WHERE Name='$name'");
		}
		$tmp_brand = mysqli_query($mysqli, "SELECT `IdBrand` FROM `Brand` WHERE Name='$brand'");
		$tmp = mysqli_fetch_array($tmp_brand);
		if (isset($tmp["IdBrand"]))
		{
			$new_brand = $tmp['IdBrand'];
			mysqli_query($mysqli, "UPDATE `product` SET IdBrand='$new_brand' WHERE Name='$name'");
		}
	}

//_____________________________________ADD____________________________________//
	if (isset($_POST['addProduct']) && $_POST['ChangeOrAddProductName'] != NULL && $_POST['ChangeOrAddProductPrice'] != NULL  && $_POST['ChangeOrAddProductPicture'] != NULL )
	{
		$new_name = htmlspecialchars($_POST['ChangeOrAddProductName']);
		$new_price = htmlspecialchars($_POST['ChangeOrAddProductPrice']);
		$new_picture = htmlspecialchars($_POST['ChangeOrAddProductPicture']);
		$category = htmlspecialchars($_POST['productCat']);
		$brand = htmlspecialchars($_POST['productBrand']);
		$tmp = mysqli_fetch_array(mysqli_query($mysqli, "SELECT `Name` FROM `product` WHERE Name='$new_name'"));
		if (!isset($tmp["Name"]))
		{
			$tmp_cat = mysqli_query($mysqli, "SELECT `IdCategory` FROM `Category` WHERE Name='$category'");
			$tmp = mysqli_fetch_array($tmp_cat);
			if (isset($tmp["IdCategory"]))
				$new_cat = $tmp['IdCategory'];
			$tmp_brand = mysqli_query($mysqli, "SELECT `IdBrand` FROM `Brand` WHERE Name='$brand'");
			$tmp = mysqli_fetch_array($tmp_brand);
			if (isset($tmp["IdBrand"]))
				$new_brand = $tmp['IdBrand'];
			if (isset($new_cat) && isset($new_brand))
				mysqli_query($mysqli, "INSERT INTO `product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('$new_name', '$new_price', '$new_picture', '$new_cat', '$new_brand')");
		}

	}



//________________________________BanUsername_________________________________//
	if (isset($_POST['deleteUsername']))
	{
		$tmp = htmlspecialchars($_POST['user']);
		mysqli_query($mysqli, "DELETE FROM `user` WHERE Username='$tmp'");
	}

	echo "<br><p style='text-align:center'>Bienvenue, admin</p><br>";
	$res_product = mysqli_query($mysqli, "SELECT `Name`, `Price`, `Picture` FROM `product`");
    $res_category = mysqli_query($mysqli, "SELECT `Name` FROM `category`");
	$res_brand = mysqli_query($mysqli, "SELECT `Name` FROM `brand`");
	$res_user = mysqli_query($mysqli, "SELECT `Username` FROM `user` WHERE Username!='admin'");
	$res_sales = mysqli_query($mysqli, "SELECT `IdStock`, `IdUser`, `Number`, `Price`, `Name` FROM `sales`");

?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/siteStyle.css">
</head>
<body>
	<div class="form_admin">
      <form method="post" action="../php/admin.php">
		  <select name="category">
			<?php
			while($category = mysqli_fetch_array($res_category))
			{
			  ?> <option value="<?php echo $category["Name"]; ?>"><?php echo $category["Name"]; ?></option> <?php
			}
			 ?>
		   </select>
		   <input type="text" name="ChangeOrAddCategory">
		   <input type="submit" name="deleteCategory" value="Supprimer">
		   <input type="submit" name="changeCategory" value="Modifier">
		   <input type="submit" name="addCategory" value="Ajouter">
    </form>
</div>
<div class="form_admin">
  <form method="post" action="../php/admin.php">
	  <select name="brand">
		<?php
		while($brand = mysqli_fetch_array($res_brand))
		{
		  ?> <option value="<?php echo $brand["Name"]; ?>"><?php echo $brand["Name"]; ?></option> <?php
		}
		 ?>
	   </select>
	   <input type="text" name="ChangeOrAddBrand">
	   <input type="submit" name="deleteBrand" value="Supprimer">
	   <input type="submit" name="changeBrand" value="Modifier">
	   <input type="submit" name="addBrand" value="Ajouter">
</form>
</div>

<!-- <div class="form_admin"> -->
<form method="post" action="../php/admin.php">
	<select name="product">
		<?php
		while($product = mysqli_fetch_array($res_product))
		{
		?> <option value="<?php echo $product["Name"]; ?>" name="productNameForDell"><?php echo $product["Name"]." ".$product["Price"]."$ ".$product["Picture"]; ?></option> <?php
		}?>
	</select>
	<select name="productCat">
		<?php
		$res_category = mysqli_query($mysqli, "SELECT `Name` FROM `category`");
		while($product = mysqli_fetch_array($res_category))
		{
		?> <option value="<?php echo $product["Name"]; ?>"><?php echo $product["Name"]; ?></option> <?php
		}?>
	</select>
	<select name="productBrand">
		<?php
		$res_brand = mysqli_query($mysqli, "SELECT `Name` FROM `brand`");
		while($product = mysqli_fetch_array($res_brand))
		{
		?> <option value="<?php echo $product["Name"]; ?>"><?php echo $product["Name"]; ?></option> <?php
		}?>
	</select>
	<label for="Name">Nom:</label>
	<input id="Name" type="text" name="ChangeOrAddProductName">
	<label for="Price">Prix:</label>
	<input id="Price" type="text" name="ChangeOrAddProductPrice">
	<label for="Picture">Image:</label>
	<input id="Picture" type="text" name="ChangeOrAddProductPicture">
	<br>
	<input type="submit" name="deleteProduct" value="Supprimer">
	<input type="submit" name="changeProduct" value="Modifier">
	<input type="submit" name="addProduct" value="Ajouter">
</form>
<!-- </div> -->

<div class="form_admin">
<form method="post" action="../php/admin.php">
	<select name="user">
	  <?php
	  while($username = mysqli_fetch_array($res_user))
	  {
		?> <option value="<?php echo $username["Username"]; ?>"><?php echo $username["Username"]; ?></option> <?php
	  }
	   ?>
	 </select>
	 <input type="submit" name="deleteUsername" value="Bannir">
</form>
</div>

<div class="form_admin">
	<p> Liste des commandes passés </p>
	<table>
		<tr><td>IdUser</td>
			<td>IdStock</td>
			<td>Quantity sold</td>
			<td>Item Price</td>
			<td>Item Name</td></tr>
		<?php
		while($sales = mysqli_fetch_array($res_sales))
		{
		  ?> <tr><td> <?php echo $sales["IdUser"];?> </td>
		  <td> <?php echo $sales["IdStock"];?> </td>
		  <td> <?php echo $sales["Number"];?> </td>
		  <td> <?php echo $sales["Price"];?> </td>
		  <td> <?php echo $sales["Name"];?> </td></tr> <?php
		}
		 ?>
	</table>
</div>

</body>
</html>
<?php
} ?>
