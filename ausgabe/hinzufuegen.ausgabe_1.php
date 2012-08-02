<form enctype="multipart/form-data" action="index.php?content=hinzufuegen" method="POST">
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
  
  <table border="1">
      <tr>
        <td>Titel:</td>
        <td></td>
      </tr>
      <tr>
        <td>Beschreibung:</td>
        <td></td>
      </tr>
      <tr>
        <td>Filmplakat:</td>
        <td></td>
      </tr>
      <tr>
        <td>Produktionsjahr:</td>
        <td></td>
      </tr>
      <tr>
        <td>Trailer:</td>
        <td></td>
      </tr>
      <tr>
        <td>Bewertung:</td>
        <td></td>
      </tr>
      <tr>
        <td>Genres:</td>
        <td></td>
      </tr>
      <tr>
        <td>Hinzufügen:</td>
        <td></td>
      </tr>
  </table>

  
  <div class="movie">
    <div class="forms add_titel">
      <p>Titel:</p><input type="text" name="movie_name" value="" />
    </div>
    <div class="forms add_beschreibung">
      <p>Beschreibung:</p><textarea name="movie_description" rows="4" cols="20"></textarea>
    </div>
    <div class="forms add_plakat">
      <p>Filmplakat: </p>
      <input type="file" name="datei" id="file" class="" /> 
    </div>
    <div class="forms add_jahr">
      <h4>Produktionsjahr:</h4>
      <select name="movie_year" id="yearpicker" >
        <option>-</option>
        <?php
        for ($i = date('Y'); $i >= 1980; $i--) {
          echo "<option>$i</option>";
        }
        ?>
      </select>
    </div>
    <div class="forms add_youtube">
      <h4>Trailer (YouTube):</h4>
      <input type="text" name="movie_youtube" value="" />
    </div>

    <div class="forms add_bewertung">
      <h4>Meine Bewertung:</h4>
      <select name="movie_my_rating" size="1">
        <option value="0" selected="selected">- Keine Angabe -</option>
        <option value="5">Sehr Gut</option>
        <option value="4">Gut</option>
        <option value="3">Befriedigend</option>
        <option value="2">Ausreichend</option>
        <option value="1">Mangelhaft</option>
      </select>
    </div>

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

    <div class="forms add_senden">     
      <input type="submit" value="Hinzufügen" name="add" />
    </div>
  </div>
</form>