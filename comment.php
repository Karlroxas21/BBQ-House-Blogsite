<?php
	include_once("config.php");

	$message = htmlspecialchars($_POST['Message']);
	$postDate = date("Y-m-d");

	if($message == ""){
		echo "<script>alert('Empty post is not allowed!');</script>";
		echo "<script>window.location.href = 'index.php';</script>";
		exit();
	}

	$sanitized_message = mysqli_real_escape_string($mysqli, $message);

	$stmt = $mysqli->prepare("INSERT INTO tblcomments (Message, PostDate) VALUES (?,?)");
	$stmt->bind_param("ss", $sanitized_message, $postDate);
	$stmt->execute();

	//echo "<scipt>alert('Comment added successfully.');</script>";
	echo "<script>window.location.href = 'index.php';</script>";

?>