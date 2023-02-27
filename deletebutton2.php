<?php
session_start();
include("./config.php");
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'blogsite');

$postDate = date("Y-m-d");

if (isset($_POST['delete2'])) {
    if (!isset($_POST['anticsrf']) || $_POST['anticsrf'] !== $_SESSION['commentdelete_token']) {
        $subject = "Anti-CSRF Token";
        $subjectMessage = "Invalid Anti-CSRF Token from Comment Delete";
        $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
        $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
        // $stmt_log->execute();

        // If error occurs
        if (!$stmt_log->execute()) {
            echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
            header('Location: ui_manage_comment.php');
            die();
        }

        echo "<script nonce='sc1'>alert('Invalid anti-CSRF token.');</script>";
        header('Location: ui_manage_comment.php');
        die();
    } else {
        $id = $_POST['ID'];

        $stmt = mysqli_prepare($connection, "DELETE FROM tblcomments WHERE ID=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $subject = "Deletion of comment";
            $subjectMessage = "Comment . $id . was deleted successfully";
            $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
            $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
            // $stmt_log->execute();

            // If error occurs
            if (!$stmt_log->execute()) {
                echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
                header('Location: ui_manage_account.php');
                die();
            }

            echo "<script nonce='sc1'>alert('Comment Deleted Successfully.');</script>";
            header('Location: ui_manage_comment.php');
        } else {
            echo "<script nonce='sc1'>alert('Error deleting comment record: " . $mysqli->error . "');</script>";
            header('Location: ui_manage_account.php');
            die();
        }
    }
}
