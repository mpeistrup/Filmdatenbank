<form id="sort" name="Filter" action="index.php">
  Sortieren nach:
  <select name="sort">
    <option value="title" <?php echo $sorter == 'title' ? 'selected="selected"' : ""; ?>>Titel</option>
    <option value="year" <?php echo $sorter == 'year' ? 'selected="selected"' : ""; ?>>Jahr</option>
    <option value="my_rating" <?php echo $sorter == 'my_rating' ? 'selected="selected"' : ""; ?>>Bewertung</option>
  </select>
  <select name="order">
    <option value="asc" <?php echo $order == 'asc' ? 'selected="selected"' : ""; ?>>Aufsteigend</option>
    <option value="desc" <?php echo $order == 'desc' ? 'selected="selected"' : ""; ?>>Absteigend</option>
  </select>
  <input type="submit" value="Los" />
</form>
<?php foreach ($inhalte as $inhalt) : ?>
  <div class="movie">
    <h2><?php echo $inhalt['title'] ?></h2> <a onClick="return showDialog(<?php echo $inhalt['id'] ?>);">DEL</a>
    <div class="content">
      <div class="left">
        <div class="picture">
          <a href="/Movies/bilder/<?php echo $inhalt['picture'] ?>">
            <img class="bigcover" src="/Movies/bilder/<?php echo $inhalt['picture'] ?>" width="160" height="240" alt="1"/>
          </a>
        </div>
        <div class="year"><?php echo $inhalt['year'] ?></div>
        <div class="my_rating">
          <div style="
               background: url(./bar.jpg) repeat-x #98CBFF;
               height: 100%;
               width: <?php echo $inhalt['rating'] ?>%;">
          </div>
        </div>
        <?php
        if (!empty($inhalt['youtube'])) {
          ?>
          <div class="youtube"><a href="<?php echo $inhalt['youtube'] ?>">Trailer ansehen</a></div>
          <?php
        };
        ?>
      </div>
      <div class="right">
        <div class="description"><?php echo $inhalt['description'] ?></div>
        <div class="genres">
          <?php if (count($inhalt['genres']) < 1): ?>
          <?php else: ?>
            <h5>Genres:</h5>
            <ul>
              <?php foreach ($inhalt['genres'] as $genre): ?>
              <li><a><?php echo $genre; ?></a></li>
              <? endforeach; ?>
            </ul>
          <?php endif; ?>

        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
<?php endforeach; ?>
<?php
//Ausgabe der Links zu den Seiten
for ($a = 0; $a < $wieviel_seiten; $a++) {
  $b = $a + 1;

  //Aktuelle Seite, keinen Link ausgeben
  if ($movie_page == $b) {
    echo "  <b>$b</b> ";
  }

  //Nicht aktuelle Seite, also einen Link ausgeben
  else {
    echo " <a href=\"?movie_page=$b&amp;sort=$sorter&amp;order=$order\">$b</a> ";
  }
}