<?php

function getArtistImage($link, $artist)
{
    $sql = "SELECT image FROM bands WHERE name = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $artist);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            $result = $stmt->get_result();

            while ($data = $result->fetch_assoc()) {
                $image = $data['image'];
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    return $image;
}

function getMostPopularAlbumsGlobal($link)
{
    $sql = "SELECT COUNT(songs.album) as listen_count, songs.album, songs.image 
            FROM listens JOIN songs on listens.song_id = songs.id 
            GROUP BY songs.album,songs.image
            ORDER BY listen_count DESC
            LIMIT 3";

    $albums = array();

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            $result = $stmt->get_result();

            while ($data = $result->fetch_assoc()) {
                $albums[] = $data;
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    return $albums;
}

function getMostPopularArtistsGlobal($link)
{
    $sql = "SELECT COUNT(songs.artist) as listen_count, songs.artist 
            FROM listens JOIN songs on listens.song_id = songs.id 
            GROUP BY songs.artist 
            ORDER BY listen_count DESC
            LIMIT 3";

    $artists = array();

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            $result = $stmt->get_result();

            while ($data = $result->fetch_assoc()) {
                $artists[] = $data;
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    return $artists;
}

function getMostPopularSongsGlobal($link)
{
    $sql = "SELECT songs.* FROM songs join (SELECT COUNT(songs.name) as listen_count, songs.name 
            FROM listens JOIN songs on listens.song_id = songs.id 
            GROUP BY songs.name
            ORDER BY listen_count DESC
            LIMIT 10) as t1 on t1.name = songs.name;";

    $songs = array();

    if ($stmt = mysqli_prepare($link, $sql)) {

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

function getMostPopularAlbumsPerUser($link, $username)
{
    $sql = "SELECT t1.listen_count, t1.album, t1.image, users.username 
            FROM (SELECT COUNT(songs.album) as listen_count, songs.album, songs.image, listens.user_id
                    FROM listens JOIN songs on listens.song_id = songs.id 
                    GROUP BY songs.album, songs.image, listens.user_id
                    ORDER BY listen_count DESC) as t1 join users on t1.user_id = users.id
            WHERE users.username = ?
            LIMIT 3;";

    $albums = array();

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            $result = $stmt->get_result();

            while ($data = $result->fetch_assoc()) {
                $albums[] = $data;
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    return $albums;
}

function getMostPopularArtistsPerUser($link, $username)
{
    $sql = "SELECT t1.listen_count, t1.artist, users.username
            FROM (SELECT COUNT(songs.artist) as listen_count, songs.artist, listens.user_id 
                    FROM listens JOIN songs on listens.song_id = songs.id 
                    GROUP BY songs.artist, listens.user_id
                    ORDER BY listen_count DESC) as t1 join users on t1.user_id = users.id
            WHERE users.username = ?
            LIMIT 3;";

    $artists = array();

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            $result = $stmt->get_result();

            while ($data = $result->fetch_assoc()) {
                $artists[] = $data;
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    return $artists;
}

function getMostPopularSongsPerUser($link, $username)
{
    $sql = "SELECT t2.id, t2.name, t2.artist, t2.album, t2.path, t2.image, users.username 
            FROM (SELECT songs.*, t1.user_id 
                    FROM songs join (SELECT COUNT(songs.name) as listen_count, songs.name, listens.user_id 
                                        FROM listens JOIN songs on listens.song_id = songs.id 
                                        GROUP BY listens.user_id, songs.name 
                                        ORDER BY listen_count DESC) as t1 on t1.name = songs.name) as t2 join users on t2.user_id = users.id 
            WHERE users.username = ? 
            LIMIT 10;";

    $songs = array();

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $username);

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
