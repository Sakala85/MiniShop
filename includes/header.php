<?php
session_start();
if(!isset($_SESSION['log'])){
  $_SESSION['log'] = 0;
}
?>
<link rel="stylesheet" type="text/css" href="/42_minishop/css/siteStyle.css">
  <ul class="header_ul">
    <li class="header_ret header_li">
      <a class="link_item" href="/42_minishop/index.php">MiniShop</a></li>
<?php
  if($_SESSION['log'] === 1 && isset($_SESSION['admin']) && $_SESSION['admin'] === 1){
    ?>
	<li class="header_li">
		<a class="link_item" href="/42_minishop/php/admin.php">Administration</a></li>
      <li class="header_li">
        <a class="link_item" href="/42_minishop/php/panier.php">Panier</a></li>
      <li class="header_li">
        <a class="link_item" href="/42_minishop/php/moncompte.php"><?php echo $_SESSION['user'] ?></a></li>
      <li class="header_li">
        <a class="link_item" href="/42_minishop/includes/deconnexion.php">Se deconnecter</a></li>
    <?php
  }
  else if($_SESSION['log'] === 1){
    ?>
      <li class="header_li">
        <a class="link_item" href="/42_minishop/php/panier.php">Panier</a></li>
      <li class="header_li">
        <a class="link_item" href="/42_minishop/php/moncompte.php"><?php echo $_SESSION['user'] ?></a></li>
      <li class="header_li">
        <a class="link_item" href="/42_minishop/includes/deconnexion.php">Se deconnecter</a></li>
    <?php
  }
  else{
    ?>
    <li class="header_li">
      <a class="link_item" href="/42_minishop/php/panier.php">Panier</a></li>
    <li class="header_li">
      <a class="link_item" href="/42_minishop/php/connexion.php">Connexion</a></li>
    <li class="header_li">
      <a class="link_item" href="/42_minishop/php/inscription.php">S'inscrire</a></li>
    <?php
  }
?>
  </ul>
