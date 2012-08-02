<form enctype="multipart/form-data" action="index.php?content=hinzufuegen" method="POST">
  <div class="movie">
    <?php
    if (isset($isset)) {
      echo $isset;
    }
    if (isset($noname)) {
      echo $noname;
    }
    if (isset($nodescription)) {
      echo $nodescription;
    }
    if (isset($norating)) {
      echo $norating;
    }
    ?>
    <table border="0">

      <tr>
        <td><h4><label for="movie_name">Titel:</label></h4></td>
        <td>
          <input type="text" name="movie_name" id="movie_name" value="" />
        </td>
      </tr>

      <tr>
        <td><h4><label for="movie_description">Beschreibung:</label></h4></td>
        <td>
          <textarea name="movie_description" id="movie_description" rows="4" cols="20"></textarea>
        </td>
      </tr>

      <tr>
        <td><h4>Filmplakat:</h4></td>
        <td>
          <input type="file" name="datei" id="file"/>
        </td>
      </tr>

      <tr>
        <td><h4>Produktionsjahr:</h4></td>
        <td>
          <select name="movie_year" id="yearpicker" >
            <option value="">-</option>
            <?php
            for ($i = date('Y'); $i >= 1980; $i--) {
              echo "<option>$i</option>";
            }
            ?>
          </select>
        </td>
      </tr>

      <tr>
        <td><h4><label for="movie_youtube">Trailer:</label></h4></td>
        <td><input type="text" name="movie_youtube" id="movie_youtube" value="" /></td>
      </tr>

      <tr>
        <td><h4>Bewertung:</h4></td>
        <td>
          <select name="movie_my_rating" size="1" id="rating">
            <option value="0" selected="selected">- Keine Angabe -</option>
            <option value="5">Sehr Gut</option>
            <option value="4">Gut</option>
            <option value="3">Befriedigend</option>
            <option value="2">Ausreichend</option>
            <option value="1">Mangelhaft</option>
          </select>
        </td>
      </tr>

      <tr>
        <td><h4>Genres:</h4></td>
        <td>
          <ul class="add_genre">
            <?php foreach ($inhalte as $inhalt): ?>
              <li>
                <input type='checkbox'
                       name='genre_<?php echo $inhalt['id']; ?>'
                       value='<?php echo $inhalt['id']; ?>'
                       id='genre_<?php echo $inhalt['id']; ?>' />
                <label for="genre_<?php echo $inhalt['id']; ?>"><?php echo $inhalt['name']; ?></label>
              </li>
            <?php endforeach; ?>
          </ul>
        </td>
      </tr>

      <tr>
        <td></td>
        <td><input type="submit" value="Hinzufügen" name="add" /></td>
      </tr>
    </table>
  </div>
</form>