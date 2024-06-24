<?php
require 'dbc.php';
session_start();


if (isset($_SESSION['new_user'])) {
    $em = $_SESSION['new_user'];
    $sql = mysqli_query($connect, "SELECT * FROM user WHERE email='$em';");
    $row2 = mysqli_fetch_assoc($sql);
    if (!$row2) {
        header("Location:home.php");
        exit();
    }
} else {
    header("Location:home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <div class="login-container">
        <div class="viewUsers" id="subMenu3">
            <div class="sub">
            <div class="homebtn">
                <a href="index.php">Home</a>
            </div>
                <?php
                $res3 = mysqli_query($connect, "SELECT * FROM admi WHERE email!='$em' ");
                while ($row5 = mysqli_fetch_assoc($res3)) {
                    echo '<div class="con">
                        <div class="name">
                        ' . htmlspecialchars($row5['userName']) . '<br>
                        </div>
                        <div class="delete-btn">
                           <a href="deleteAdmin.php?aId=' . $row5['email'] . '"  style="color:#ffffff">Delete</a>
                       </div>
                    </div>

                    <hr>';
                }
                ?>
               
            </div>
        </div>
    </div>
</body>

</html>