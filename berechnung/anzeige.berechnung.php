<?php

// Anzeige
// Berechnungen, DB-Anfragen werden hier verarbeitet.
$pagetitle = "Filme";

// Folgende Wörter sollen beim sortieren nicht beachtet werden
$boese_anfaenge = array(
  "/^(?:The )/i",
  "/^(?:Der )/i",
  "/^(?:Die )/i",
  "/^(?:Das )/i"
);

// Pager
// Speicher in '$movie_page' die aktuelle Seite (Seite 1, Seite 2,...)
$movie_page = (isset($_GET['movie_page']) && strval(intval($_GET['movie_page'])) === strval($_GET['movie_page'])) ? $_GET['movie_page'] : 1;
// Max. Anzahl der Filme auf einer Seite
$movies_per_page = 10;
// Erstelle ein Offset für die Ergebnise pro Seite
$offset = ($movie_page - 1) * $movies_per_page;


// Filme holen
$query_result = mysql_query("SELECT `id`, `title`, `year`, `my_rating`
                             FROM `movies` 
                             ORDER BY `id`
                             ASC;") or die(mysql_error());

// Erstelle $sorter für das Suchkriterium. Wenn noch keines vorhanden ist, nehme 'title'
$sorter = (isset($_GET['sort'])) ? $_GET['sort'] : "title";
$order = (isset($_GET['order'])) ? $_GET['order'] : "asc";

// Movie keys into array
while ($row = mysql_fetch_array($query_result, MYSQL_ASSOC)) {
  $new = array();
  $new['id'] = $row['id'];

// Wechsel $sorter im Fall von...
  switch ($sorter) {
    case 'year':
      $new['sort_criteria'] = $row['year'];
      break;

    case 'my_rating':
      $new['sort_criteria'] = $row['my_rating'];
      break;

    default:
      $new['sort_criteria'] = preg_replace($boese_anfaenge, '', $row['title']);
      break;
  }

  $inhalte[] = $new;
  unset($new);
}

// Sortieren nach 'sort_criteria' 
function cmp($a, $b) {
  global $order;
// Wechsel $order im Fall von...
  switch ($order) {
    case 'asc':
      if (strtolower($a['sort_criteria']) == strtolower($b['sort_criteria'])) {
        return 0;
      }
      return ($a['sort_criteria'] < $b['sort_criteria']) ? -1 : 1;
      break;
    case 'desc':
      if (strtolower($a['sort_criteria']) == strtolower($b['sort_criteria'])) {
        return 0;
      }
      return ($a['sort_criteria'] < $b['sort_criteria']) ? 1 : -1;
      break;
  }
  
}

usort($inhalte, "cmp");

$inhalte_neu = array_splice($inhalte, $offset, $movies_per_page);


/*
 * Daten holen
 */
$meineFilme = array();
foreach ($inhalte_neu as $film) {
  $id = $film['id'];
  $qry = "SELECT m.*,
    GROUP_CONCAT(g.name) AS `genres`
            FROM movies AS m
       LEFT JOIN genre_to_movies AS gtm
              ON (m.id = gtm.movie_id) 
       LEFT JOIN genres AS g
              ON (gtm.genre_id = g.id)
           WHERE m.id = '$id'
        GROUP BY m.id
           LIMIT 1";
  $res = mysql_query($qry) or die(mysql_error());
  $row = mysql_fetch_array($res, MYSQL_ASSOC);

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

  $meineFilme[] = $new;
}

$inhalte = $meineFilme;

$menge = mysql_num_rows($query_result);
$wieviel_seiten = ceil($menge / $movies_per_page);

echo "</div>";