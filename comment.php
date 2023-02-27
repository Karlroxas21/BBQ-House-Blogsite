<?php
session_start();
include_once("config.php");

$message = htmlspecialchars($_POST['Message']);
$postDate = date("Y-m-d");

if ($message == "") {
	$subject = "Comment";
	$subjectMessage = "Message is not posted because it is empty.";
	$stmt_log = $mysqli -> prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
	$stmt_log -> bind_param("sss", $postDate, $subject, $subjectMessage);
	// $stmt_log -> execute();

	//If error occurs
	if (!$stmt_log -> execute()) {
		echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
		header('Location: index.php');
		die();
	}

	echo "<script nonce='sc1'>alert('Empty post is not allowed!');</script>";
	header('Location: index.php');
	die();
}

if (isset($_POST['comment_submit'])) {
	if (!isset($_POST['anticsrf']) || $_POST['anticsrf'] !== $_SESSION['comment_token']) {
		$subject = "Anti CSRF-Token";
		$subjectMessage = "Invalid Anti-CSRF Token from Comment Post";
		$stmt_log = $mysqli -> prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
		$stmt_log -> bind_param("sss", $postDate, $subject, $subjectMessage);
		// $stmt_log -> execute();
		
		//If error occurs
		if (!$stmt_log -> execute()) {
			echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
			header('Location: index.php');
			die();
		}

		echo "<script nonce='sc1'>alert('Invalid anti-CSRF token');</script>";
		header('Location: index.php');
		die();
	}else{
		$sanitized_message = mysqli_real_escape_string($mysqli, $message);

		$stmt = $mysqli->prepare("INSERT INTO tblcomments (Message, PostDate) VALUES (?,?)");
		$stmt->bind_param("ss", $sanitized_message, $postDate);
		// $stmt->execute();

		//If error occurs
		if (!$stmt->execute()) {
			echo "<script nonce='sc1'>alert('Error inserting comment: " . $mysqli->error . "');</script>";
			header('Location: index.php');
			die();
		}
			
		$subject = "Comment";
		$subjectMessage = "Comment was posted";
		$stmt_log = $mysqli -> prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
		$stmt_log -> bind_param("sss", $postDate, $subject, $subjectMessage);
		// $stmt_log -> execute();

		//If error occurs
		if (!$stmt_log -> execute()) {
			echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
			header('Location: index.php');
			exit();
		}
		
		echo "<script nonce='sc1'>alert('Comment Added Successfully.');</script>";
		header('Location: index.php');
	}
}
