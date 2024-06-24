<?php
require 'dbc.php';
$output="";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>brands</title>
</head>
<body>
    <?php
    if(isset($_POST['submit'])){

       $name=$_POST['bn'];
       $b_image= $_FILES['b_image']['name'];
       $b_image_tmp_name = $_FILES['b_image']['tmp_name'];
       $b_image_folder ='brands/'.$b_image;
       
       $check=mysqli_query($connect,"SELECT *FROM brand WHERE brand_name='$name'");
       $res=mysqli_num_rows($check);
       $error=array();
       if(empty($name)){
        $error['l']="Enter product name";
       }else if($res>0){
        $error['l']="brand already exist";
       }

       if(isset($error['l'])){
         $output.="<p class='alert'>".$error['l']."</p>";
       }else{
        $output.="";
       }
       if(count($error)<=0 ){  
            $insert=mysqli_query($connect,"INSERT INTO brand(brand_name ,image_address)
            VALUES('$name','$b_image_folder')") or die('query failed');

            if($insert){
                    move_uploaded_file($b_image_tmp_name,$b_image_folder);
                    $output.="<p class='success'>product add succesfully into folder_arrivals</p>";  
                    header("Location:index.php");
            }
            else{
                $output.="<p class='success'>Failed to add product into folder_arrivals</p>";
            }
       }

    }
    ?>
</body>
</html>