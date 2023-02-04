<?php

if(isset($_POST['Submit'])) {

	include 'config.php';

	$name =$_POST['Name'];
	$email =$_POST['Email'];
	$pass =$_POST['Password'];
	$cpassword=$_POST['cpassword'];
	$createdDate = date("Y-m-d");
	$modifiedDate = date("Y-m-d");
	if ($pass == $cpassword) {

	$pass = mysqli_real_escape_string($mysqli, $pass);
	$pass = password_hash($pass, PASSWORD_DEFAULT);

	$sql="INSERT INTO tblaccounts(Name,Email,Password,CreatedDate,ModifiedDate)
	VALUES('$name','$email','$pass','$createdDate','$modifiedDate')";

	
if (mysqli_query($mysqli, $sql)) {
	header("Location: index.php?success=Account created successfully");
	echo "<scipt>Account created successfully</script>";
  } else {
	echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
  }
} else {
	header("Location: index.php?error=The passwords you entered do not match");
	echo "<scip>The passwords you entered do not match</script>";
}
}

	// echo "<scipt>alert('Data added successfully.');</script>";
	echo "<script>window.location.href = 'index.php';</script>";

?>