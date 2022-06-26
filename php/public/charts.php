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
    <link rel="stylesheet" type="text/css" href="css/charts.css" />
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

    <?php

    require_once("../src/config.php");
    require_once("../src/chartsHandler.php");
    require_once("../src/displaySongs.php");

    $artists = getMostPopularArtistsGlobal($link);

    echo "<h1>Most Popular Artists</h1><div class='chart'>";

    foreach ($artists as $artist) {
        $image = getArtistImage($link, $artist['artist']);
        echo "<div class='chart-entry'>
                <img class='chart-img' src='../../{$image}' alt='band photo'>
                <h3>{$artist['artist']}</h3>
                </div>";
    }
    echo "</div>";

    $albums = getMostPopularAlbumsGlobal($link);

    echo "<h1>Most Popular Albums</h1><div class='chart'>";

    foreach ($albums as $album) {

        echo "<div class='chart-entry'>
                <img class='chart-img' src='../{$album['image']}' alt='band photo'>
                <h3>{$album['album']}</h3>
                </div>";
    }
    echo "</div>";

    echo "<h1>Most Popular Songs</h1>";

    $songs = getMostPopularSongsGlobal($link);

    displaySongsChart($songs);

    ?>

</body>

</html>