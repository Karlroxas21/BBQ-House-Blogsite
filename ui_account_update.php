<?php
session_start();
require("session_check.php");
include('./anti-csrf-tokens/tokens.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BBQ Blog</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="shortcut icon" type="image/jpg" href="images/iconlogo.png" />

  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script src="js/jquery.validate.min.js"></script>
</head>

<body>
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="Logo" width="130" height="50" />
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
      $postDate = date("Y-m-d");

      $connection = mysqli_connect("localhost", "root", "");
      $db = mysqli_select_db($connection, 'blogsite');

      $id = $_POST['ID'];
      if (isset($_POST['edit'])) {
        if (!isset($_POST['anticsrf']) || $_POST['anticsrf'] !== $_SESSION['accountupdate_token']) {
          $subject = "Anti CSRF-Token";
          $subjectMessage = "Invalid Anti-CSRF Token from Account Update";
          $stmt_log = $mysqli->prepare("INSERT INTO logs (Date, Subject, Message) VALUES (?, ? ,?)");
          $stmt_log->bind_param("sss", $postDate, $subject, $subjectMessage);
          // $stmt_log->execute();

          // If error occurs
          if (!$stmt_log->execute()) {
            echo "<script nonce='sc1'>alert('Error inserting log record: " . $mysqli->error . "');</script>";
            header('Location: ui_manage_account.php');
            die();
          }

          // invalid token
          echo "<script nonce='sc1'>alert('Invalid anti-CSRF token');</script>";
          header('Location: ui_manage_account.php');
          die();
        } else {
          $stmt = mysqli_prepare($connection, "SELECT * FROM tblaccounts WHERE ID=?");
          mysqli_stmt_bind_param($stmt, "i", $id);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
        }
      }
      if ($result) {
        while ($row = mysqli_fetch_array($result)) {
      ?>

          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">Edit Users Accounts</h1>
            </div>

            <form action="update.php" method="POST" class="needs-validation" novalidate>
              <input type="hidden" name="anticsrf" value="<?php echo $_SESSION['accountupdatesave_token']; ?>">

              <input type="hidden" name="ID" value="<?php echo $row['ID'] ?>">

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
                <input type="password" class="form-control" id="Password" name="Password" placeholder="Enter Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                <label for="toggle"><input type="checkbox" name="togglepw" id="togglepw">Show Password</label>
              </div>

              <div class="mb-3 float-end">
                <button type="submit" name="update" class="btn bt-sm btn-primary p-3">Save</button>
                <a href="ui_manage_account.php" class="btn btn-sm btn-danger p-3">Cancel</a>
              </div>
            </form>
          </main>
    </div>
  </div>
<?php
        }
      } else {
        // If error occurs
        echo "<script nonce='sc1'>alert('Error displaying accounts record: " . $mysqli->error . "');</script>";
        header('Location: ui_manage_account.php');
        die();
      }

?>
</div>
</div>
<script nonce="regvalidation">
  (function() {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
      .forEach(function(form) {
        form.addEventListener('submit', function(event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
  })()
</script>
<script src="js/dashboard.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/feather.min.js"></script>
<script nonce="feather">
  feather.replace()
</script>
<script src="./togglepw.js"></script>
</body>

</html>