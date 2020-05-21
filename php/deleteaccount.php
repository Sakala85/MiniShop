<?php
	session_start();
	$mysqli = mysqli_connect("localhost", "minishop", "minishop", "minidb");
	if (isset($_SESSION['user']) && isset($_SESSION['password']) && $_SESSION['user'] != "admin")
	{
		$username = htmlspecialchars($_SESSION['user']);
		// mysqli_query($mysqli, "DELETE FROM `sales` JOIN `user` ON sales.IdUser=user.IdUser WHERE user.Username='$username'");
		mysqli_query($mysqli, "DELETE FROM `user` WHERE Username='$username'");

	}
	if ($_SESSION['user'] === "admin")
		header('location: ../php/moncompte.php');
	else
		header('location: ../includes/deconnexion.php');

 ?>
