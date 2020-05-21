<?php
  session_start();
  $mysqli = mysqli_connect("localhost", "minishop", "minishop", "minidb");
  $res = mysqli_query($mysqli, "SELECT Name FROM `category`");
  $res_brand = mysqli_query($mysqli, "SELECT Name FROM `brand`");
  ?>
<link rel="stylesheet" type="text/css" href="/42_minishop/css/siteStyle.css">
<div class="sidenav">
    <h1 class="menu_title">Categories</h1>
  <?php
  while ($cat = mysqli_fetch_array($res)) {
      $tmp = $cat["Name"];
        ?>
        <a href="/42_minishop/index.php?category=<?php echo $tmp; ?>"><?php echo $tmp; ?></a>
        <?php
    }
    ?>
    <h1 class="menu_title">Brands</h1>
  <?php
  while ($cat_brand = mysqli_fetch_array($res_brand)) {
      $tmp_brand = $cat_brand["Name"];
        ?>
        <a href="/42_minishop/index.php?brand=<?php echo $tmp_brand; ?>"><?php echo $tmp_brand; ?></a>
        <?php
    }
?>
</div>
