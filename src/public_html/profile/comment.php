<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/notify.php';

function comment_post($conn, $userID, $postID, $comment) {
    $sql = "INSERT INTO comments (User, entityType, Comment, entityID) VALUES ('{$userID}', 'Post', '{$comment}', '{$postID}')";
    if (mysqli_query($conn, $sql)) {
        echo "Commented successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $sql = "UPDATE post SET Comments = Comments + 1 WHERE ID = '{$postID}'";
    if (mysqli_query($conn, $sql)) {
        echo "Updated successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

function comment_comment($conn, $userID, $postID, $commentID, $comment) {
    $sql = "INSERT INTO comments (User, entityType, Comment, entityID) VALUES ('{$userID}', 'Commento', '{$comment}', '{$commentID}')";
    if (mysqli_query($conn, $sql)) {
        echo "Commented successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    $sql = "UPDATE post SET Comments = Comments + 1 WHERE ID = '{$postID}'";
    if (mysqli_query($conn, $sql)) {
        echo "Updated successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

}

?>