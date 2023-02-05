<?php
	include_once("config.php");

	$message = htmlspecialchars($_POST['Message']);
	$postDate = date("Y-m-d");

	$stmt = $mysqli->prepare("INSERT INTO tblcomments (Message, PostDate) VALUES (?,?)");
	$stmt->bind_param("ss", $message, $postDate);
	$stmt->execute();

	//echo "<scipt>alert('Comment added successfully.');</script>";
	echo "<script>window.location.href = 'index.php';</script>";

?>