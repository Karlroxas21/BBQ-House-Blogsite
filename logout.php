<?php
session_start();
include('./config.php');

$postDate = date("Y-m-d");

$subject = "Account Logged out";
$subjectMessage = "Account logged out . $_SESSION[user_email].";
$stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
$stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
// $stmt_log -> execute();

// If error occurs
if (!$stmt_log->execute()) {
    echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
    header('Location: index.php');
    die();
}

session_unset();
session_destroy();

header("location: index.php");
