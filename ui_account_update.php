<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>BBQ Blog</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="shortcut icon" type="image/jpg" href="images/iconlogo.png"/>

  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script src="js/jquery.validate.min.js"></script>   
</head>

<body>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="Logo" width="130" height="50"/>
      </a>
      <a class="btn btn-outline-success" href="logout.php">Logout</a>
    </div>
  </header>


  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3 sidebar-sticky">
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link active text-dark" aria-current="page" href="ui_admin_dashboard.php">
                <span data-feather="home" class="align-text-bottom mt-3 text-primary"></span>
                Dashboard
              </a>
            </li>
          </ul>

          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>DATA ADMINISTRATION</span>
          </h6>
          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link" href="ui_manage_account.php">
                <span data-feather="users" class="align-text-bottom text-primary"></span>
                Accounts Management
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="ui_manage_comment.php">
                <span data-feather="message-circle" class="align-text-bottom text-primary"></span>
                Posts Management
              </a>
            </li>
          </ul>
        </div>
      </nav>
      
      <?php
      $connection= mysqli_connect("localhost","root","");
      $db =mysqli_select_db($connection, 'blogsite');
      
      $id = $_POST['ID'];

      $stmt = mysqli_prepare($connection, "SELECT * FROM tblaccounts WHERE ID=?");
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
            
      if($result)
      {
        while ($row = mysqli_fetch_array($result))
        {
          ?>

          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Edit Users Accounts</h1>
        </div>

        <form action="" method="POST">
          <input type="hidden" name="ID" value="<?php echo $row['ID']?>">
          <div class="mb-3">
            <label for="Name" class="form-label">Name</label>
            <input type="text" class="form-control" id="Name" name="Name" value="<?php echo $row['Name']; ?>" placeholder="Enter Name" required>
          </div>
          <div class="mb-3">
            <label for="Email" class="form-label">Email</label>
            <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $row['Email'] ?>" placeholder="Enter Email" required>
          </div>
          <div class="mb-3">
            <label for="Password" class="form-label">Password</label>
            <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter Password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
				    title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
            <input type="checkbox" onclick="togglePassword(this)"> Show Password</input>
          </div>
          
          <div class="mb-3 float-end">
            <button type="submit" name="update" class="btn bt-sm btn-primary p-3">Save</button>
            <a href="ui_manage_account.php" class="btn btn-sm btn-danger p-3">Cancel</a>
          </div>
        </form>
        </main>
        <?php
        if(isset($_POST['update']))
        {
          if($_POST['Password'] == ''){
            $name = $_POST['Name'];
            $email = $_POST['Email'];
            $query = "UPDATE tblaccounts SET Name='$name', Email='$email' WHERE ID=?";
            // $ = mysqli_query($connection, $query);
            $query_run = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($query_run, "i", $id);
            mysqli_stmt_execute($query_run);
            
            if($query_run)
            {
              echo "<script>window.location.href = 'ui_manage_account.php'</script>"  ;
            }
          }else{
            $name = $_POST['Name'];
            $email = $_POST['Email'];
            $pass = password_hash($_POST['Password'], PASSWORD_DEFAULT);
            $query = "UPDATE tblaccounts SET Name='$name', Email='$email', Password='$pass' WHERE ID=?";
            // $ = mysqli_query($connection, $query);
            $query_run = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($query_run, "i", $id);
            mysqli_stmt_execute($query_run);
            
            if($query_run)
            {
              echo "<script>window.location.href = 'ui_manage_account.php'</script>"  ;
            }
          }
        }
        ?>
      </div>
    </div>
    <?php
        }
    }
    else
      ?>
    </div>
  </div>

    
  <script src="js/dashboard.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/feather.min.js"></script>
  <script>
    feather.replace()
  </script>
  <script>
	function togglePassword(btn) {
		var passwordInput = document.getElementById("Password");
		if (passwordInput.type === "password") {
			passwordInput.type = "text";
			btn.value = "Hide";
		} else {
			passwordInput.type = "password";
			btn.value = "Show";
		}
		}
	</script>
</body>
</html>