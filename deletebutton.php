<?php
session_start();
include("./config.php");
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'blogsite');

$postDate = date("Y-m-d");

if (isset($_POST['delete'])) {
    if (!isset($_POST['anticsrf']) || $_POST['anticsrf'] !== $_SESSION['accountdelete_token']) {
        $subject = "Anti-CSRF Token";
        $subjectMessage = "Invalid Anti-CSRF Token from Account Delete";
        $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
        $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
        // $stmt_log->execute();

        // If error occurs
        if (!$stmt_log->execute()) {
            echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
            header('Location: ui_manage_account.php');
            die();
        }

        // invalid token
        echo "<script nonce='sc1'>alert('Invalid anti-CSRF token');</script>";
        echo "<script nonce='sc1'>window.location.href = 'ui_manage_account.php'</script>";
        die();
    } else {
        $id = $_POST['ID'];

        $query = "DELETE FROM tblaccounts WHERE ID='$id'";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $subject = "Deletion of account";
            $subjectMessage = "Account . $id . was deleted successfully";
            $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
            $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
            // $stmt_log->execute();

            // If error occurs
            if (!$stmt_log->execute()) {
                echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
                header('Location: ui_manage_account.php');
                die();
            }

            echo "<script nonce='sc1'>alert('Account Deleted Successfully');</script>";
            echo "<script nonce='sc1'>window.location.href = 'ui_manage_account.php'</script>";
        } else {
            echo "<script nonce='sc1'>alert('Error deleting account record: " . $mysqli->error . "');</script>";
            header('Location: ui_manage_account.php');
            die();
        }
    }
}
