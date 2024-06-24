<?php
require 'dbc.php';

if(isset($_SESSION['new_user'])){
    $em=$_SESSION['new_user'];  
    $sql=mysqli_query($connect,"SELECT * FROM user WHERE email='$em';");
    $row=mysqli_fetch_assoc($sql);
    if(!mysqli_num_rows($sql)>0){
        header("Location:home.php");
    }
} else{
    header("Location:home.php");  
} 

if (isset($_GET['uId'])) {
    $uId = $_GET['uId'];
    
    $delete_query = mysqli_query($connect, "DELETE FROM user WHERE email = '$uId'");

    if ($delete_query) {
        header("Location: viewUsers.php");
    } else {
        echo "Error deleting review: " . mysqli_error($connect);
    }
} else {
    echo "Invalid request. Missing rId parameter.";
}
?>
