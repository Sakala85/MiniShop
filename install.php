<?php
	header('Location: index.php');

	function    create_database($conn, $name)
	{
		$sql = "CREATE DATABASE ".$name;
		if (mysqli_query($conn, $sql))
		{
			echo "Database ".$name." created successfully<br>\n";
			return (true);
		}
		else
		{
			echo "Error creating database: " . mysqli_error($conn)."<br>\n";
			return (false);
		}
	}

	function	create_table($conn, $name, $columns)
	{
		$sql = "CREATE TABLE ".$name."(".$columns.")";
		if (mysqli_query($conn, $sql))
			echo "Table ".$name." created successfully<br>\n";
		else
			echo "Error creating table: " . mysqli_error($conn)."<br>\n";
	}

	function	get_price($product)
	{
		if ($product === "jean")
			return 50;
		if ($product === "polo")
			return 60;
		if ($product === "tshirt")
			return 30;
		if ($product === "shoes")
			return 100;
	}

	$server = 'localhost:3306';
	$username = 'minishop';
	$password = 'minishop';
	$db = 'miniDB';

	$conn = mysqli_connect($server, $username, $password);
	if (!$conn)
		die("Connection failed: " . mysqli_connect_error());
	if (create_database($conn, $db) == true)
	{
		mysqli_close($conn);
		$conn = mysqli_connect($server, $username, $password, $db);
		if (!$conn)
			die("Connection failed: " . mysqli_connect_error());
		create_table($conn, 'Category', "	IdCategory INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
											Name VARCHAR(255) NOT NULL");
		create_table($conn, 'Brand',	"	IdBrand INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
											Name VARCHAR(255) NOT NULL");
		create_table($conn, 'Product',	"	IdProduct INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
											Name VARCHAR(255) NOT NULL,
											Price INT(6) UNSIGNED NOT NULL,
											Picture VARCHAR(255) NOT NULL,
											IdCategory INT(6) UNSIGNED, FOREIGN KEY
											FkCategory(IdCategory)
											REFERENCES Category(IdCategory)
											ON DELETE CASCADE,
											IdBrand INT(6) UNSIGNED, FOREIGN KEY
										  	FkBrand(IdBrand)
											REFERENCES Brand(IdBrand)
											ON DELETE CASCADE");
		create_table($conn, 'Stock',	"	IdStock INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
											IdProduct INT(6) UNSIGNED, FOREIGN KEY
											FkProduct(IdProduct)
											REFERENCES Product(IdProduct)
											ON DELETE CASCADE,
											Stock INT(6) UNSIGNED NOT NULL,
											Size VARCHAR(255) NOT NULL");
		create_table($conn, 'User',		"	IdUser INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
											Username VARCHAR(255) NOT NULL,
											Password VARCHAR(255) NOT NULL,
											Mail VARCHAR(255) NOT NULL,
											Address VARCHAR(255) NOT NULL");
		create_table($conn, 'Sales',	"	IdSales INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
											IdStock INT(6) UNSIGNED, FOREIGN KEY
											FkStock(IdStock)
											REFERENCES Stock(IdStock)
											ON DELETE CASCADE,
											IdUser INT(6) UNSIGNED, FOREIGN KEY
											FkUser(IdUser)
											REFERENCES User(IdUser)
											ON DELETE CASCADE,
											Number INT(6) UNSIGNED NOT NULL,
											Price INT(6) UNSIGNED NOT NULL,
											Name VARCHAR(255) NOT NULL");

		$pass = hash('whirlpool', 'admin');
		mysqli_query($conn, "INSERT INTO `User` (`Username`, `Password`, `Mail`, `Address`) VALUES ('admin', '$pass', 'admin', 'admin')");

		mysqli_query($conn, "INSERT INTO `Category` (`Name`) VALUES ('Jean')");
		mysqli_query($conn, "INSERT INTO `Category` (`Name`) VALUES ('Polo')");
		mysqli_query($conn, "INSERT INTO `Category` (`Name`) VALUES ('Chaussures')");
		mysqli_query($conn, "INSERT INTO `Category` (`Name`) VALUES ('T-Shirt')");

		mysqli_query($conn, "INSERT INTO `Brand` (`Name`) VALUES ('Levis')");
		mysqli_query($conn, "INSERT INTO `Brand` (`Name`) VALUES ('Ralph Lauren')");
		mysqli_query($conn, "INSERT INTO `Brand` (`Name`) VALUES ('Adidas')");
		mysqli_query($conn, "INSERT INTO `Brand` (`Name`) VALUES ('Lacoste')");

		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('501 Bleu Clair', '90', 'jean-levis-clearblue.png', '1', '1')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('501 Bleu', '501', 'jean-levis-blue.png', '1', '1')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('501 Noir', '90', 'jean-levis-dark.png', '1', '1')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Adidas Jean Bleu Clair', '50', 'jean-adidas-clearblue.png', '1', '3')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Adidas Jean Bleu', '50', 'jean-adidas-blue.png', '1', '3')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Adidas Jean Noir', '50', 'jean-adidas-dark.png', '1', '3')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Lacoste Rouge', '40', 'polo-lacoste-red.png', '2', '4')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Lacoste Bleu', '40', 'polo-lacoste-blue.png', '2', '4')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Lacoste Noir', '45', 'polo-lacoste-black.png', '2', '4')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Ralph Lauren Rouge', '75', 'polo-ralph-red.png', '2', '2')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Ralph Lauren Bleu', '75', 'polo-ralph-blue.png', '2', '2')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Ralph Lauren Noir', '70', 'polo-ralph-black.png', '2', '2')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Levis Grises', '130', 'shoes-levis-gray.png', '3', '1')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Levis Marrons', '110', 'shoes-levis-brown.png', '3', '1')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Adidas Blanches', '95', 'shoes-adidas-white.png', '3', '3')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('Adidas Rouges', '99', 'shoes-adidas-red.png', '3', '3')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('T-Shirt Rouge', '20', 'tshirt-adidas-red.png', '4', '3')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('T-Shirt Bleu', '25', 'tshirt-adidas-blue.png', '4', '3')");
		mysqli_query($conn, "INSERT INTO `Product` (`Name`, `Price`, `Picture`, `IdCategory`, `IdBrand`) VALUES ('T-Shirt Noir', '27', 'tshirt-adidas-black.png', '4', '3')");

		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('1', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('1', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('1', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('2', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('2', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('2', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('3', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('3', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('3', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('4', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('4', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('4', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('5', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('5', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('5', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('6', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('6', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('6', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('7', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('7', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('7', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('8', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('8', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('8', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('9', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('9', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('9', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('10', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('10', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('10', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('11', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('11', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('11', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('12', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('12', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('12', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('13', '255', '40')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('13', '255', '41')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('13', '255', '42')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('13', '255', '43')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('14', '255', '40')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('14', '255', '41')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('14', '255', '42')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('14', '255', '43')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('15', '255', '40')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('15', '255', '41')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('15', '255', '42')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('16', '255', '40')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('16', '255', '41')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('16', '255', '42')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('16', '255', '43')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('17', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('17', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('17', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('18', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('18', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('18', '255', 'L')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('19', '255', 'S')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('19', '255', 'M')");
		mysqli_query($conn, "INSERT INTO `Stock` (`IdProduct`, `Stock`, `Size`) VALUES ('19', '255', 'L')");
	}
	mysqli_close($conn);
?>
