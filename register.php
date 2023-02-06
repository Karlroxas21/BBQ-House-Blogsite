<?php

if(isset($_POST['Submit'])) {

    include 'config.php';

    $name = htmlspecialchars($_POST['Name']);
    $email = htmlspecialchars($_POST['Email']);
    $pass = htmlspecialchars($_POST['Password']);
    $cpassword= htmlspecialchars($_POST['cpassword']);
    $createdDate = date("Y-m-d");
    $modifiedDate = date("Y-m-d");
    if ($pass == $cpassword) {

        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $mysqli->prepare("INSERT INTO tblaccounts(Name,Email,Password,CreatedDate,ModifiedDate)
	    VALUES(?,?,?,?,?)");
        $stmt->bind_param("sssss", $name, $email, $pass, $createdDate, $modifiedDate);
        $stmt->execute();

        if ($stmt->affected_rows === 1) {
            echo "<script>alert('Account created succesfuly');
            window.location.href= 'index.php'</script>";
        }
    } else {
        echo "<script>alert('The passwords you entered do not match');
        window.location.href= 'index.php'</script>";
    }
    $stmt->close();
}

?>