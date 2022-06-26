<?php

require_once "config.php";

echo time();

function getUserIdByName($link, $user)
{
    $sql = "SELECT id FROM users WHERE username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $username);

        // set parameters
        $username = $_POST['User_Name'];

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            $result = $stmt->get_result();

            while ($data = $result->fetch_assoc()) {
                $user = $data;
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    return $user['id'];
}

$sql = "INSERT INTO listens(user_id, song_id, played_at) VALUES (?, ?, FROM_UNIXTIME(?))";

if ($stmt = mysqli_prepare($link, $sql)) {

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "iis", $user_id, $song_id, $date);

    // set parameters
    $user_id = getUserIdByName($link, $_POST['User_Name']);
    $song_id = $_POST['Song_Id'];
    $date = time();

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
