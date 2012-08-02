<?php

// Anzeige
// Berechnungen, DB-Anfragen werden hier verarbeitet.
$pagetitle = "Filmliste";


// Folgende Wörter sollen beim sortieren nicht beachtet werden
$boese_anfaenge = array(
  "/^(?:The )/i",
  "/^(?:Der )/i",
  "/^(?:Die )/i",
  "/^(?:Das )/i"
);

// Get movies
$query_result = mysql_query("SELECT m.*,
              GROUP_CONCAT(g.name) AS `genres`
         FROM movies AS m
    LEFT JOIN genre_to_movies AS gtm
           ON (m.id = gtm.movie_id) 
    LEFT JOIN genres AS g
           ON (gtm.genre_id = g.id)
     GROUP BY m.id
     LIMIT $start, $mpp;") or die(mysql_error());

$sorter = (isset($_GET['sort'])) ? $_GET['sort'] : "title";

// Movie keys into array
while ($row = mysql_fetch_array($query_result, MYSQL_ASSOC)) {
  $new = array();
  $new['title'] = $row['title'];
  $new['description'] = str_replace('Penner', "*piep*", $row['description']);
  $new['picture'] = $row['picture'];
  $new['year'] = $row['year'];
  $new['youtube'] = $row['youtube'];
  $new['my_rating'] = $row['my_rating'];
  $new['rating'] = $row['my_rating'] * 20;
  $new['id'] = $row['id'];
  $new['genres'] = ($row['genres'] != '') ? explode(",", $row['genres']) : NULL;

  switch ($sorter) {
    case 'year':
      $new['sort_criteria'] = $new['year'];
      break;

    default:
      $new['sort_criteria'] = preg_replace($boese_anfaenge, '', $row['title']);
      break;
  }

  $inhalte[] = $new;
  unset($new);
}

/**
 * sort by criteria
 */
function cmp($a, $b) {
  if (strtolower($a['sort_criteria']) == strtolower($b['sort_criteria'])) {
    return 0;
  }
  return ($a['sort_criteria'] < $b['sort_criteria']) ? -1 : 1;
}

usort($inhalte, "cmp");



$result = mysql_query("SELECT id FROM movies");
$menge = mysql_num_rows($result);

//Errechnen wieviele Seiten es geben wird
$wieviel_seiten = $menge / $mpp;