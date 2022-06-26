<?php

// make sure user is authenticated before accessing the page
require_once("../src/auth.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="#">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <title>Music Player</title>
</head>

<body>
  <nav class="top-nav">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="charts.php">Charts</a></li>
      <li><a id="user" href="#"><?php echo $_SESSION['username']; ?></a>
        <ul>
          <li><a href="myPlaylists.php">My Playlists</a></li>
          <li><a href="aboutMe.php">About me</a></li>
          <li><a href="../src/login/logout.php">Log out</a></li>
        </ul>
      </li>
    </ul>
  </nav>

  <h1>Music Player</h1>

  <div class="music-container" id="music-container">
    <div class="music-info">
      <h4 id="title"></h4>
      <span id="artist"></span><span> &#8226; </span><span id="album"></span>
      <div class="progress-container" id="progress-container">
        <div class="progress" id="progress"></div>
      </div>
      <div class="time">
        <span id="currTime"></span>
        <span id="durTime"></span>
      </div>
    </div>

    <audio src="../assets/music/A Lifetime Of Adventure.mp3" id="audio"></audio>

    <div class="img-container">
      <img src="../assets/images/A Lifetime Of Adventure.jpg" alt="music-cover" id="cover" />
    </div>
    <div class="navigation">
      <button id="prev" class="action-btn">
        <i class="fas fa-backward"></i>
      </button>
      <button id="play" class="action-btn action-btn-big">
        <i class="fas fa-play"></i>
      </button>
      <button id="next" class="action-btn">
        <i class="fas fa-forward"></i>
      </button>
    </div>
  </div>

  <div class="catalogue">
    <?php
    require "../src/displaySongs.php";
    require "../src/playlistHandler.php";

    if (!isset($_SESSION['songs'])) {
      $_SESSION['songs'] = getSongs(0, $link);
    }

    if (array_key_exists('test', $_POST)) {
      $loaded_songs_count = count($_SESSION['songs']);
      $_SESSION['songs'] = getSongs($loaded_songs_count, $link);
    }

    $playlists = getPlaylists($link, $_SESSION['username']);
    displaySongs($_SESSION['songs'], 0, $playlists);

    ?>
    <div class="center">
      <form method="post" action="index.php#load-more">
        <input id="load-more" type="submit" class="btn" name="test" value="Load More">
      </form>
    </div>
  </div>

  <script src="javascript/jquery.js"></script>
  <script src="javascript/playerController.js"></script>

  <script src="dropDownButtonController.js"></script>

</body>

</html>