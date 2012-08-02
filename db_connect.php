<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
      
    $mysqlhost = "192.168.1.62";
    $mysqluser = "wiethe";
    $mysqlpw = "wiethe";
    $mysqldb = "azubi_marius_fdb";

    $connection = mysql_connect($mysqlhost, $mysqluser, $mysqlpw)
      or die("Verbindungsversuch fehlgeschlagen.");
    mysql_select_db($mysqldb, $connection)
      or die("Datenbank wurde nicht gefunden.");
    
    $result = mysql_query("SELECT * FROM genres ORDER BY name") or die(mysql_error());
?>
