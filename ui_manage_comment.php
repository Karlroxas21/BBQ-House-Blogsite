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

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Post Management</h1>
        </div>
        <div class="container">
            <table class="table table-responsive table striped">
              <?php
                    $connection= mysqli_connect("localhost","root","");
                    $db =mysqli_select_db($connection, 'blogsite');

                    $query = "SELECT * FROM tblcomments";
                    $query_run = mysqli_query($connection, $query);
                    ?>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Comment(s)</th>
                        <th>Posted Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if($query_run)
                    {
                      while($row = mysqli_fetch_array($query_run))
                      {
                        ?>
                    <tr>
                      <th><?php echo $row['ID']; ?> </th>
                      <th><?php echo $row['Message']; ?> </th>
                      <th><?php echo $row['PostDate']; ?> </th>
                      
                      <th> <input type="submit" value="DELETE" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"></th>

                      <!-- Modal -->
                      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Delete Comment</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <h6 class="modal-title" id="exampleModalLabel">You are about to delete this comment. <br> 
                            This action cannot be undone. Are you sure you want to delete this comment?</h6>
                              <form action="deletebutton2.php" method="POST">
                                <input type="hidden" name="ID" value="<?php echo $row['ID']?>">
                                <div class ="modal-footer">
                                <button type ="submit" name="delete2" class="btn btn-warning">Delete</button>
                                <button type ="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </tr>
                </tbody>
                <?php
                }
              }
              ?>
              </table>    
            </div>
            <!-- MODAL ENDS HERE -->
      
          <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="ui_manage_comment.php"><b>Previous</b></a></li>
            <li class="page-item"><a class="page-link" href="ui_manage_comment.php"><b>1</b></a></li>
            <li class="page-item"><a class="page-link" href="ui_manage_comment.php"><b>2</b></a></li>
            <li class="page-item"><a class="page-link" href="ui_manage_comment.php"><b>3</b></a></li>
            <li class="page-item"><a class="page-link" href="ui_manage_comment.php"><b>Next</b></a></li>
          </ul>
          
      </main>
    </div>
  </div>
    
  <script src="js/dashboard.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/feather.min.js"></script>
  <script>
    feather.replace()
  </script>
</body>
</html>