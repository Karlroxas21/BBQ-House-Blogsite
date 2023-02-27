<?php
session_start();
include 'config.php';

if (isset($_POST['Submit'])) {
    $postDate = date("Y-m-d");

    $name = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['Name']));
    $email = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['Email']));
    $pass = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['Password']));
    $cpassword = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['cpassword']));
    $createdDate = date("Y-m-d");
    $modifiedDate = date("Y-m-d");

    $sanitized_anticsrf = mysqli_real_escape_string($mysqli, $_POST['anticsrf']);
    if (!isset($sanitized_anticsrf) || $sanitized_anticsrf !== $_SESSION['register_token']) {
        $subject = "Anti CSRF-Token";
        $subjectMessage = "Invalid Anti-CSRF Token from Register";
        $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
        $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
        // $stmt_log->execute();

        // If error occurs
        if (!$stmt_log->execute()) {
            echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
            header('Location: index.php');
            die();
        }
        header('Location: index.php');
        die();
    }

    if ($pass != $cpassword) {
        $subject = "Register Account";
        $subjectMessage = "Password entered do not match";
        $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
        $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
        $stmt_log->execute();

        // If error occurs
        // if (!$stmt_log->execute()) {
        //     echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
        //     header('Location: index.php');
        //     die();
        // }

        echo "<script nonce='sc1'>alert('The passwords you entered do not match');
            window.location.href='./index.php';</script>";

        return;
    }

    $pass = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $mysqli->prepare("INSERT INTO tblaccounts(Name,Email,Password,CreatedDate,ModifiedDate)
            VALUES(?,?,?,?,?)");
    $stmt->bind_param("sssss", $name, $email, $pass, $createdDate, $modifiedDate);
    // $stmt->execute();

    if (!$stmt->execute()) {
        // If error occurs
        echo "<script nonce='sc1'>alert('Error registering account record: " . $mysqli->error . "');</script>";
        header('Location: index.php');
        die();
    }

    if ($stmt->affected_rows === 1) {
        $subject = "Register Account";
        $subjectMessage = "Account Registered . $email.";
        $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
        $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
        // $stmt_log->execute();

        // If error occurs
        if (!$stmt_log->execute()) {
            echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
            header('Location: index.php');
            die();
        }

        echo "<script nonce='sc1'>alert('Account created succesfuly');
                window.location.href='./index.php';</script>";
        return;
    }
    $stmt->close();
}
