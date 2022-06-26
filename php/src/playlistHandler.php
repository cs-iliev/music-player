<?php

require_once "config.php";

function getPlaylistSongs($link, $username, $playlist)
{
    $sql = "SELECT songs.* 
            FROM songs JOIN (SELECT song_id 
                            FROM playlists 
                            WHERE playlist_name = ? AND user_id = (SELECT users.id 
                                                                    FROM users
                                                                    WHERE username = ?)) as t1
                        on songs.id = t1.song_id;";

    $songs = array();

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $playlist, $username);

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

function getPlaylists($link, $username)
{
    $sql = "SELECT DISTINCT playlist_name 
            FROM playlists
            WHERE user_id = (SELECT users.id 
                                FROM users
                                WHERE username = ?);";

    $playlists = array();

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            $result = $stmt->get_result();

            while ($data = $result->fetch_assoc()) {
                $playlists[] = $data['playlist_name'];
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    return $playlists;
}
