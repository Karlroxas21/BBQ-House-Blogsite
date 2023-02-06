<?php
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'blogsite');

if(isset($_POST['delete2']))
{
    $id = $_POST['ID'];

    $stmt = mysqli_prepare($connection, "DELETE FROM tblcomments WHERE ID=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result=mysqli_stmt_execute($stmt);

    // $query = "DELETE FROM tblcomments WHERE ID='$id'";
    // $result = mysqli_query($connection, $query);


    if($result){
        echo "<script>alert('Comment Deleted Successfully.');
        window.location.href ='ui_manage_comment.php'</script>";
    }
}
?>