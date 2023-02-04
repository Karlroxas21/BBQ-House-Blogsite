<?php
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'blogsite');

if(isset($_POST['delete2']))
{
    $id = $_POST['ID'];

    $query = "DELETE FROM tblcomments WHERE ID='$id'";
    $query_run = mysqli_query($connection, $query);

    if($query_run)
    {
        //echo "<scipt>alert('Comment Deleted Successfully.');</script>";
        header("location:ui_manage_comment.php");
    }
}
?>