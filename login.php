<?php
session_start();
include('config.php');

try {
    $conn = new PDO(
        "mysql:host=$databaseHost; dbname=blogsite",
        $databaseUsername,
        $databasePassword
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed : " . $e->getMessage();
}

$postDate = date("Y-m-d");

$email = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['Email']));
$pass = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['Password']));

$stmt = $conn->prepare("SELECT * FROM tblaccounts WHERE Email= :email");
$stmt->bindParam(':email', $email);
// $stmt->execute();

// If error occurs
if (!$stmt->execute()) {
    echo "<script nonce='sc1'>alert('Error logging in: " . $mysqli->error . "');</script>";
    header('Location: index.php');
    die();
}

if (isset($_POST['login'])) {
    if (!isset($_POST['anticsrf']) || $_POST['anticsrf'] !== $_SESSION['login_token']) {
        $subject = "Anti CSRF-Token";
        $subjectMessage = "Invalid Anti-CSRF Token from Login";
        $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
        $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
        // $stmt_log->execute();

        // If error occurs
        if (!$stmt_log->execute()) {
            echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
            header('Location: index.php');
            die();
        }

        // invalid token
        echo "<script nonce='sc1'>alert('Invalid anti-CSRF token')
            window.location.href= 'index.php'</script>";
        die();
    } else {
        if ($stmt->rowCount() < 1) {
            $subject = "Account Login";
            $subjectMessage = "Account does not exist . $email.";
            $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
            $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
            // $stmt_log->execute();

            // If error occurs
            if (!$stmt_log->execute()) {
                echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
                header('Location: index.php');
                die();
            }

            echo "<script nonce='sc1'>alert('Account does not exist')
                window.location.href= 'index.php'</script>";
        } else {
            $user = $stmt->fetch();
            $user_id = $user['ID'];
            $user_name = $user['Name'];
            $user_email = $user['Email'];
            $user_pass = $user['Password'];

            if (!password_verify($pass, $user_pass)) {
                $subject = "Account Login";
                $subjectMessage = "Invalid Email or Password . $email.";
                $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
                $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
                // $stmt_log->execute();

                // If error occurs
                if (!$stmt_log->execute()) {
                    echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
                    header('Location: index.php');
                    die();
                }

                echo "<script nonce='sc1'>alert('Invalid Email or Password')
                    window.location.href= 'index.php'
                </script>";
            } else {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $user_email;
                $_SESSION['user_name'] = $user_name;
                $_SESSION['logged_in'] = true;
                $_SESSION['time'] = time();

                $subject = "Account Login";
                $subjectMessage = "Account logged in .$user_email.";
                $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
                $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
                // $stmt_log->execute();

                // If error occurs
                if (!$stmt_log->execute()) {
                    echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
                    header('Location: ui_admin_dashboard.php');
                    die();
                }

                echo "<script nonce='sc1'>alert('Welcome " . $user['Name'] . "!');</script>"; //changed
                echo "<script nonce='sc1'>window.location.href='ui_admin_dashboard.php';</script>"; //changed
            }
        }
    }
}
