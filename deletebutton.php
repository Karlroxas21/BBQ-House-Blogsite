<?php
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'blogsite');

if(isset($_POST['delete']))
{
    $id = $_POST['ID'];

    $query = "DELETE FROM tblaccounts WHERE ID='$id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        //echo "<scipt>alert('Account Deleted Successfully');</script>";
        echo "<script>window.location.href = 'ui_manage_account.php'</script>";

    }
}
?>