<?php
header('Content-type: text/html; charset=utf-8');

// Get Content and Page
$myContent = isset($_GET['content']) ? $_GET['content'] : 'anzeige';

require 'db_connect.php';

if (!file_exists("berechnung/$myContent.berechnung.php")) {
  $myContent = "error404";
}
if (!isset($movie_page)) {
  $movie_page = 1;
}
require "berechnung/$myContent.berechnung.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link href="style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="script.js"></script>
    <title>Filmdatenbank - <?php echo $pagetitle; ?></title>
  </head>
  <body>
    <div id="container">
      <h1><?php echo $pagetitle; ?></h1>
      <div id="menu">
        <a href="index.php?content=anzeige"><div id="home"></div></a>
        <a href="index.php?content=hinzufuegen"><div id="add"></div></a>
      </div>
      <?php
        require "ausgabe/$myContent.ausgabe.php";
      ?>
    </div>    
  </body>
</html>