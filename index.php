<?php
require 'dbc.php';
session_start();

if(isset($_GET['logout'])){
    session_destroy();
    header("Location:home.php");
}

if(isset($_SESSION['new_user'])){
    $em=$_SESSION['new_user'];  
    $sql=mysqli_query($connect,"SELECT * FROM user WHERE email='$em';");
    $row2=mysqli_fetch_assoc($sql);
    if(!mysqli_num_rows($sql)>0){
        header("Location:home.php");
    }
} else{
    header("Location:home.php");  
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ABC Private Limited</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
</head>
<body >
    <header>
    <a  class="logo" href="#" ><img class="logo" src="logo.png" alt=""></a>
            <div id="menu-bar">l></div>
        <nav class="navbar">
           <?php
            if (isset($_SESSION['new_user'])) {
                $ue = $_SESSION['new_user'];
                $result1 = mysqli_query($connect, "SELECT * FROM  admi WHERE email='$ue'");
                $chkresult1=mysqli_num_rows($result1);
            }
            ?> 
            <a href="#reveiw">customer reviews</a>         
            <a href="viewProducts.php">shop</a>
            <a href="admin.php"><i data-toggle="tooltip" class="ri-shopping-cart-2-line"></i> </a>
            <a href="#"><i data-toggle="tooltip" class="ri-heart-line"></i></i> </a>
        </nav>
        <div class="down-box">
        <div class="outter-box">
            <form action="search.php" method="post" enctype="multipart/form-data"> 
                <input class="search-bar" name="search-bar" type="text" placeholder="Search Here...">
                <button class="search-icon" name="search"><i class="fas fa-search"></i></button>
            </form>
        </div>
       </div>
        <a href="#" class="signuplogo" onclick="toggleMenu()" >
            <img src="219983.png">
        </a>
            <div  id="subMenu2">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="219983.png">
                        <div class="texts">
                            <h2><?php echo $row2['userName']; ?></h2>
                            <h3><?php echo $row2['email']; ?></h3>
                        </div>
                    </div>
                    <hr>

                    <a href="editProfile.php">
                        <img src="user-circle-solid-24.png" alt="">
                        <p>Edit Profile</p>
                        <span>></span>
                    </a>
                    <?php 
                    if($chkresult1){
                        echo '<a href="#" onclick="openMenu()">
                        <img src="user-circle-solid-24.png" alt="">
                        <p>View users</p>
                        <span>></span>
                        </a>';
                    } ?>
                    <a href="">
                        <img src="help-circle-solid-24.png" alt="">
                        <p>Help</p>
                        <span>></span>
                    </a>
                    <a href="">
                        <img src="cog-solid-24.png" alt="">
                        <p>Settings & Privacy</p>
                        <span>></span>
                    </a>
                    <a href="index.php?logout" class='logoutbtn'>
                        <img src="horizontal-right-regular-24.png" alt="">
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div> 
    </header>
    <div class="viewUsers" id="subMenu3">
            <div class="sub">
                <div class="cancel">
                    <div class="topic">
                        <h1>Users list</h1>
                    </div>
                    <div class="icon" onclick="cancelMenu()">
                        x
                    </div>
                </div>
                <?php 
                $result1 = mysqli_query($connect, "SELECT * FROM user WHERE email='$ue'");
                $res3 = mysqli_query($connect, "SELECT * FROM user");
                while ($row5 = mysqli_fetch_assoc($res3)) {
                    $row6 = mysqli_fetch_assoc($result1);
                    if($row5 && !$row6){
                    echo '<div class="con">
                            <div class="name">
                            ' . $row5['userName'] . '<br>
                            </div>
                            <div class="view">
                                <a href="viewUserDetails.php?aId=' . $row5['email'] . '">view</a>
                            </div>
                    </div>
                    <hr>
                    ';
                    }
                }
                ?>
            </div>
        </div>
    <section class="popular" id="popular" onclick="closeSubMenu()">
        <h1 class="heading"> <span> OUR</span> BRANDS</h1>
        <div class="box-container">
            <?php
            if(isset($_SESSION['new_user'])){
                $ue=$_SESSION['new_user'];
                $sql="SELECT * FROM admi WHERE email='$ue';";
                $result1=mysqli_query($connect,$sql);
                $row3= mysqli_fetch_assoc($result1);
                $chkresult1=mysqli_num_rows($result1);
                if($chkresult1){
                    echo '<div class="box" style="background-color: rgba(180, 180, 180, 0.326);">
                    <a href="brands.php"><img class="plus" style=" position:relative; top:15px; padding:30px;"src="images\plus.png" alt=""></a>
                    <h1 style="color:gray; font-size:2.5rem; position: relative;top: 5rem;">add brand</h1>
                    <div class="stars">
                        
                    </div>
                    <div class="">
                        <p></p>
                        <a href="" class=""></a>
                    </div>
                </div>';
               }
            }

            ?>
                <?php
    $select_brands= mysqli_query($connect, "SELECT * FROM brand ORDER BY brand_id desc");
    if(mysqli_num_rows($select_brands) > 0){
        while($row1 = mysqli_fetch_assoc($select_brands)){
    ?>
    <div class="box">
        <img src="<?php echo $row1['image_address']; ?>" alt="">
        <h3><?php echo $row1['brand_name']; ?></h3>
        <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
        </div>
        <?php
        if($chkresult1){
        echo '<div class="update">
                 <a href="updateBrand.php? brand_Id= '. $row1['brand_id'] . '">Update</a>
              </div>
              <div class="update">
                 <a href="#">add products</a>
              </div>';
        }else{
        echo '
            <div class="update">
                <a href="#">View products</a>
            </div>';
        } ?>
    </div>
    <?php
        }  
    } else {
        echo "<div class='empty'>no brands added</div>";
    };
    ?>
</div>
        </div>
    </section>

<section class="reveiw" id="reveiw">
        <h1 > <span>CUSTOMER</span> REVIEWS</h1>
        <div class="addingReview">
            <form action="addreview.php" method="POST"  enctype="multipart/form-data">
                <div >
                    <input type="hidden" value="<?php echo $row2['userName'] ?>" name="rn">
                </div> 
                <div class="input-box" >
                    <input type="text" placeholder="Add your review here " name="des">
                </div> 
                <div class="button">
                    <input type="submit" value="Add" name="submit">
                </div>
            </form>
       </div>
        <div class="box-container">
        <?php
$select_reviews = mysqli_query($connect, "SELECT * FROM review ORDER BY rId desc");
if(mysqli_num_rows($select_reviews) > 0) {
    while($row8 = mysqli_fetch_assoc($select_reviews)) {
        ?>
        <div class="box">
                <img src="images\customers.png" alt="">
                <h3> <?php echo $row8['reviewerName']; ?></h3>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <div class="content">
                    <p> <?php echo $row8['review'] ?></p>
                </div>
                <?php
                    if ( isset($row3['userName'])) {
                        if ($row3['userName']) {
                            echo '<a href="delete_review.php?rId=' . $row8['rId'] . '">delete</a>';
                        }
                    }else if(isset($row8['reviewerName']) ){
                        if($row8['reviewerName'] == $row2['userName'] ){
                            echo '<a href="delete_review.php?rId=' . $row8['rId'] . '">delete</a>'; 
                        }
                    }
                ?>
            </div>
<?php
    }
}
?>
        </div>
</section>
<section class="steps" >
        <div class="step-heading">
            <h1>
               At <span style="color:red; background-color:white; padding:0 2px; border-radius:10px;">AFIXGEAR</span>, we take pride in delivering top-notch services to meet all your motor spare parts needs. Our commitment revolves around providing a seamless experience for automotive enthusiasts, mechanics, and businesses alike. Here's what sets our services apart:
            </h1>
        </div>
        <div class="box">
            <img style="width:39%" src="setting.png" alt="" style="height:60%">
            <h3>choose what you need</h3>
        </div>
        <div class="box">
            <img style="width:70%"src="pngwing.com (1).png" alt="">
            <h3>free and fast delivery</h3>
        </div>
        <div class="box">
            <img src="pngwing.com (2).png" alt="">
            <h3>ease payments methods</h3>
        </div>
        <div class="box">
            <img src="pngwing.com (3).png" alt="">
            <h3>and Finally,fix your vehicle</h3>
        </div>
    </section>
    <section class="footer">
        <div class="share">
            <a href="" class="btn">facebook</a>
            <a href="" class="btn">twitter</a>
            <a href="" class="btn">instagram</a>
            <a href="" class="btn">linkedin</a>
        </div>
        <h1 class="credit"><span>a group project</span> | all rights reserved!</h1>
    </section>

<script src="script.js"></script>

  </body>  
</html>