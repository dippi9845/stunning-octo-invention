<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/../functions.php';
header('Content-Type: application/json; charset=utf-8');
session_start();

if (isset($_SESSION['userID']) && isset($_GET['text']) && isset($_GET['postID'])) {

    $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/../setup.json'));
    $conn = new mysqli("localhost", $data->dbName, $data->dbPassword, $data->dbUserName);

    $stmt = $conn->prepare("INSERT INTO comment (User, entityID, entityType, Text) VALUE (?, ?, 'Post', ?)");
    $stmt->bind_param("sis", getUserNameByID($conn, $_SESSION['userID']), $_GET['postID'], $_GET['text']);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE post SET Comments=Comments + 1 WHERE ID = ?");
    $stmt->bind_param("i", $_GET['postID']);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare(
        "SELECT ProfileImagePath as ProfileImage, Nickname as User
        FROM `users`
        WHERE `ID` = ?");

    $stmt->bind_param("i", $_SESSION['userID']);
    $stmt->execute();
    $result = $stmt->get_result();
    $mydata = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    echo json_encode($mydata[0]);
}
?>