<?php
session_start();
include('config.php');

try {
    $conn = new PDO("mysql:host=$databaseHost; dbname=blogsite", 
                    $databaseUsername, $databasePassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}
// LOGIN USER
if (isset($_POST['Email']) && isset($_POST['Password'])) {
	$email = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['Email']));
	$pass = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['Password']));

	if(empty($email)){
		header("Location: index.php?error=Email is required");
		echo "<scipt>Email is required</script>";
	}else if(empty($pass)){
		header("Location: index.php?error=Password is required&email=$email");
		echo "<scipt>Password is required</script>";
	}else{
		$stmt = $conn->prepare("SELECT * FROM tblaccounts WHERE Email=?");
		$stmt->execute([$email]);

		if($stmt->rowCount() === 1){
			$user = $stmt->fetch();

            $user_id =$user['ID'];
			$user_name =$user['Name'];
			$user_email =$user['Email'];
			$user_pass =$user['Password'];

			if ($email === $user_email) {
				if (password_verify($pass, $user_pass)) {
					$_SESSION['user_id'] = $user_id;
					$_SESSION['user_email'] = $user_email;
					$_SESSION['user_name'] = $user_name;
					
					header("Location: ui_admin_dashboard.php");
				
				}else {
			header("Location: index.php?error=Incorect User name or password&email=$email");
		}
	}else {
		header("Location: index.php?error=Incorect User name or password&email=$email");
	}
}else {
	header("Location: index.php?error=Incorect User name or password&email=$email");
}
	}
}

