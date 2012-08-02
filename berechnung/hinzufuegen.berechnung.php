<?php

// Hinzufügen
// Berechnungen, DB-Anfragen werden hier verarbeitet.

// Definiere $pagetitle
$pagetitle = "Film hinzufügen";

// Query für die Genre's
$query_result = mysql_query("SELECT * FROM genres ORDER BY name") or die(mysql_error());

// Genre keys into array
while ($row = mysql_fetch_array($query_result, MYSQL_ASSOC)) {
  $new = array();
  $new['id'] = $row['id'];
  $new['name'] = $row['name'];
  $inhalte[] = $new;
  unset($new);
}
//$inhalte[] enthält mehrere Arrays mit 2 Keys, jeweils 1 String pro Key

// Wenn Formular abgeschickt...
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Wenn der Post 'movie_name' leer ist, deklariere $noname
  if (empty($_POST['movie_name'])) {
    $noname = "<div id='fail'>Nicht belegt: Titel</div><br />";
  };
  // Wenn der Post 'movie_description' leer ist, deklariere $nodescription
  if (empty($_POST['movie_description'])) {
    $nodescription = "<div id='fail'>Nicht belegt: Beschreibung</div><br />";
  };
  // Wenn der Post 'movie_my_rating' leer ist, deklariere $norating
  if ($_POST['movie_my_rating'] == 0) {
    $norating = "<div id='fail'>Nicht belegt: Bewertung</div><br />";
  };

// Wenn Werte gesetzt sind...
  if (!isset($noname) &&
      !isset($nodescription) &&
      !isset($norating)){

// Genre into array
    $myGenres = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $genre_name = "genre_" . $row['id'];
      if (array_key_exists($genre_name, $_POST)) {
        $myGenres[] = $row['id'];
      }
    }

// Hole die nächste ID ($nextid) für die JPG
    $query_result = mysql_query("SELECT id FROM movies ORDER BY id DESC LIMIT 1");
    while ($row = mysql_fetch_array($query_result, MYSQL_ASSOC)) {
      $nextid = $row['id'] + 1;
    }

// Dateiprüfung
    $fname = $_FILES['datei']['name'];

    if ($_FILES['datei']['name'] != '') {
      $typeAccepted = array("image/jpeg", "image/jpg", "image/gif", "image/png");

      if (in_array($_FILES['datei']['type'], $typeAccepted)) {

        $fname = preg_replace(array("#[,./]#", "#[^a-zA-Z0-9]#"), array("", "_"), $fname);

        if ($_FILES['datei']['type'] == "image/jpeg")
          $fname = $nextid . ".jpg";
        elseif ($_FILES['datei']['type'] == "image/jpg")
          $fname = $nextid . ".jpg";
        elseif ($_FILES['datei']['type'] == "image/gif")
          $fname = $nextid . ".gif";
        else
          $fname = $nextid . ".png";

        $uploaddir = 'bilder/';

        $uploadfile = $uploaddir . basename($fname);

        is_uploaded_file($_FILES['datei']['tmp_name']);

        move_uploaded_file($_FILES['datei']['tmp_name'], "bilder/" . $fname);
      } else {
        $fname = "nopicture.jpg";
      }
    } else {
      $fname = "nopicture.jpg";
    }
// Get genres
    $result = mysql_query("SELECT * FROM genres ORDER BY name")
      or die(mysql_error());
// Genre-ID into $row['id']
    $myGenres = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
      $genre_name = "genre_" . $row['id'];
      if (array_key_exists($genre_name, $_POST)) {
        $myGenres[] = $row['id'];
      }
    }

    mysql_query("INSERT INTO movies
                  (`title`,
                   `description`,
                   `year`,
                   `my_rating`,
                   `youtube`,
                   `picture`)
                   VALUES
                   ('" . mysql_real_escape_string($_POST['movie_name']) . "',
                    '" . mysql_real_escape_string($_POST['movie_description']) . "',
                    '" . mysql_real_escape_string($_POST['movie_year']) . "',
                    '" . mysql_real_escape_string($_POST['movie_my_rating']) . "',
                    '" . mysql_real_escape_string($_POST['movie_youtube']) . "',
                    '" . mysql_real_escape_string($fname) . "')")
      or DIE(mysql_error());
    $last_id = mysql_insert_id();

    foreach ($myGenres as $genre) {
      mysql_query("INSERT INTO genre_to_movies (`movie_id`, `genre_id`) VALUES ('" . $last_id . "', '" . $genre . "')") or DIE(mysql_error());
    }
    $isset = "<div id='success'>Film hinzugefügt!</div>";
    return 'add.php';
  }
}