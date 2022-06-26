<?php

require_once "config.php";

$songs = array();

function getSongs($loaded_songs_count, $link)
{
  $sql = "SELECT * FROM songs LIMIT ?";

  $songs = array();

  if ($stmt = mysqli_prepare($link, $sql)) {

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $display_count);

    // set parameters
    $display_count = strval($loaded_songs_count + LOAD_MORE_COUNT);

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
      // Store result
      $result = $stmt->get_result();

      while ($data = $result->fetch_assoc()) {
        $songs[] = $data;
      }
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
  }

  return $songs;
}

function displaySongs($songs, $loaded_songs_count, $playlists)
{
  $start_index = $loaded_songs_count;

  for ($i = $start_index; $i < count($songs); $i++) {

    $song = $songs[$i];
    $json = json_encode($song);

    echo "<div id='catalogue-entry-{$song['id']}' class='catalogue-entry' data-json='{$json}'>
      <div class='catalogue-entry-img'>
        <img src='../../{$song['image']}' alt='music-cover'>
      </div>
      <div class='catalogue-entry-content'>
        <p class='ellipsis'>{$song['name']}</p>
        <p class='ellipsis'>{$song['artist']} &#8226; {$song['album']}</p>
      </div>
      <div class='catalogue-entry-actions'>
        <nav class='btn-nav'>
	        <ul>
            <li><button id='{$song['id']}' class='catalogue-entry-action-btn catalogue-play fas fa-play' ></button></li>
		        <li><button class='catalogue-entry-action-btn fas fa-plus'></button>
			        <ul>
				        <li><a href='../../{$song['path']}' download>Download</a></li>
				        <li><a>Add to playlist</a>
					        <ul>
						        <li><a>Create new</a></li>
						        <p>Your playlists:</p>";

    foreach ($playlists as $playlist) {
      echo "<li><a>{$playlist}</a></li>";
    }

    echo "</ul>
				        </li>
			        </ul>
		        </li>
	        </ul>
        </nav>
      </div>
    </div>";
  }
}

function displaySongsChart($songs)
{

  echo "<div class='song-chart-wrapper'>";

  foreach ($songs as $song) {

    echo "<div class='song-chart'>
      <div class='catalogue-entry-img'>
        <img src='../../{$song['image']}' alt='music-cover'>
      </div>
      <div class='catalogue-entry-content'>
        <p class='ellipsis'>{$song['name']}</p>
        <p class='ellipsis'>{$song['artist']} &#8226; {$song['album']}</p>
      </div>
    </div>";
  }

  echo "</div>";
}
