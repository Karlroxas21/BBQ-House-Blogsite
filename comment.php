<?php
	include_once("config.php");

	$message =$_POST['Message'];
	$postDate = date("Y-m-d");

	$result = mysqli_query($mysqli, "INSERT INTO tblcomments(Message,PostDate)
	VALUES('$message','$postDate')");

	//echo "<scipt>alert('Comment added successfully.');</script>";
	echo "<script>window.location.href = 'index.php';</script>";

?>