<?php
session_start();
include("./config.php");
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'blogsite');

$id = $_POST['ID'];

$postDate = date("Y-m-d");

if (isset($_POST['update'])) {
    $sanitized_anticsrf = mysqli_real_escape_string($mysqli, $_POST['anticsrf']);
    if (!isset($sanitized_anticsrf) || $sanitized_anticsrf !== $_SESSION['accountupdatesave_token']) {
        $subject = "Anti CSRF-Token";
        $subjectMessage = "Invalid Anti-CSRF Token from Update Account";
        $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
        $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
        $stmt_log->execute();

        // If error occurs
        // if (!$stmt_log->execute()) {
        //     echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
        //     header('Location: ui_manage_account.php');
        //     die();
        // }

        // invalid token
        echo "<script nonce='sc1'>alert('Invalid anti-CSRF token');</script>";
        header('Location: ui_manage_account.php');
        die();
    } else {
        if ($_POST['Password'] == '') {
            $name = $_POST['Name'];
            $email = $_POST['Email'];
            $query = "UPDATE tblaccounts SET Name='$name', Email='$email' WHERE ID=?";
            // $ = mysqli_query($connection, $query);
            $query_run = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($query_run, "i", $id);
            mysqli_stmt_execute($query_run);

            if ($query_run) {
                $subject = "Account Update";
                $subjectMessage = ".$id . was updated";
                $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
                $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
                // $stmt_log->execute();

                // If error occurs
                if (!$stmt_log->execute()) {
                    echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
                    header('Location: ui_manage_account.php');
                    die();
                }

                header('Location: ui_manage_account.php');
            } else {
                // If error occurs
                echo "<script nonce='sc1'>alert('Error updating account: " . $mysqli->error . "');</script>";
                header('Location: ui_manage_account.php');
                die();
            }
        } else {
            $name = $_POST['Name'];
            $email = $_POST['Email'];
            $pass = password_hash($_POST['Password'], PASSWORD_DEFAULT);
            $query = "UPDATE tblaccounts SET Name='$name', Email='$email', Password='$pass' WHERE ID=?";
            // $ = mysqli_query($connection, $query);
            $query_run = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($query_run, "i", $id);
            mysqli_stmt_execute($query_run);

            if ($query_run) {
                $subject = "Account Update";
                $subjectMessage = ".$id . password was updated";
                $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
                $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
                $stmt_log->execute();

                // If error occurs
                // if (!$stmt_log->execute()) {
                //     echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
                //     header('Location: ui_manage_account.php');
                //     die();
                // }

                header('Location: ui_manage_account.php');
            } else {
                // If error occurs
                echo "<script nonce='sc1'>alert('Error updating account: " . $mysqli->error . "');</script>";
                header('Location: ui_manage_account.php');
                die();
            }
        }
    }
}
