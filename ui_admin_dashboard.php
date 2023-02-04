<?php
session_start();
include('config.php');

if (isset($_SESSION['user_id']) && isset($_SESSION['user_email'])) { 
  ?>

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
      <a class="btn btn-outline-success" name= "logout" href="logout.php">Logout</a>
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

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Dashboard</h1>
        </div>
        
        <div class="row justify-content-center">
          <div class="col-md-5 mb-5">
            <div class="card bg-warning text-dark h-100">
              <i class="fa-solid fa-user-plus fa-5x card-body py-8 "></i>
              <div class="card-body py-8 "><b>User Registration</b>
              
              
              <?php
               $db= mysqli_select_db($mysqli, 'blogsite');

               $dash_user_query = "SELECT * From tblaccounts";
               $dash_user_query_run = mysqli_query($mysqli, $dash_user_query);

              if($user_total = mysqli_num_rows($dash_user_query_run))
              {
                echo '<h4 class="mb-0">'.$user_total.' </h4>';
              }
              else{
                echo '<h4 class="mb-0">No Data</h4>';
              }
              ?>
              </div>

              <div class="card-footer d-flex align-items-center justify-content-center">
                <a class="small text-dark stretched-link" href="#">More Info</a>
                <i class="fa-solid fa-circle-arrow-right"></i>
              </div>
            </div>
          </div>
          
          <div class="col-md-5 mb-5">
            <div class="card bg-danger text-white h-100">
            <i class="fa-solid fa-comments fa-5x card-body py-2"></i>
              <div class="card-body py-5"><b>Comments</b>

              <?php
               $db= mysqli_select_db($mysqli, 'blogsite');

               $dash_comment_query = "SELECT * From tblcomments";
               $dash_comment_query_run = mysqli_query($mysqli, $dash_comment_query);

              if($comment_total = mysqli_num_rows($dash_comment_query_run))
              {
                echo '<h4 class="mb-0">'.$comment_total.' </h4>';
              }
              else{
                echo '<h4 class="mb-0">No Data</h4>';
              }
              ?>
              </div>   

              <div class="card-footer d-flex align-items-center justif-content-between">

              </div>
            </div>
          </div>
        </div>

              <?php include_once('config.php'); ?>

              <!-- Table (ChartJS)-->
              <?php
                $query= "SELECT DATE_FORMAT(PostDate, '%m') AS month, COUNT(*) AS num_rows
                FROM tblcomments GROUP BY DATE_FORMAT(PostDate, '%m') ORDER BY month ASC";
                $result = mysqli_query($mysqli, $query);
            
                $num_row_each_month = array();
            
                while ($row = mysqli_fetch_assoc($result)){
                    $month = $row['month'];
                    $num_rows = $row['num_rows'];
          
                    array_push($num_row_each_month, $num_rows);
                }
            
                $num_row_each_month_json = json_encode($num_row_each_month);
              ?>
              <div class="container">
                <canvas id="myChart"></canvas>
              </div>
      </main>
    </div>
  </div>
    
  <script src="js/dashboard.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/feather.min.js"></script>
  <script>
    feather.replace()
  </script>
  <!-- CHART JS -->
  <script src="./node_modules/chart.js/dist/chart.umd.js"></script>
  <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July',
          'August', 'September', 'October', 'November', 'December'
        ],
        datasets: [{
          label: '# Comments',
          data: <?php echo $num_row_each_month_json; ?>,
          borderWidth: 2
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
  <script src="https://kit.fontawesome.com/c98e6d63c0.js" crossorigin="anonymous"></script>

</body>
</html>
<?php 
}else {
   header("Location: index.php");
}
 ?>
