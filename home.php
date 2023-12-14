<?php
require 'dbc.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> ABC Private Limited</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        @media(max-width:768px){
        .reveiw .box-container .box{
            width: 40%;
        }
        
        }
        @media(max-width:576px){
        .reveiw .box-container .box{
            width: 100%;
        }

        }
    </style>
</head>
<body >
    <header>
                <a  class="logo" href="#" ><img class="logo" src="logo.png" alt=""></a>
            <div id="menu-bar" class="fas fa-bars"></div>
            <nav class="navbar">
                <a href="#home" class="active">home</a>
                <a href="#reveiw">customer reviews</a>
                <a href="#steps">servises</a>
            </nav>
            <div class="con10">
                <a  href="signup.php">Register</a>
                <a  href="login.php">Log In</a>              
            </div>
            <div class="down-box">
        <div class="outter-box">
            <form action="search.php" method="post" enctype="multipart/form-data"> 
                <input class="search-bar" name="search-bar" type="text" placeholder="Search Here...">
                <button class="search-icon" name="search"><i class="fas fa-search"></i></button>
            </form>
        </div>
       </div>
    </header>
    <section class="home" id="home"  >
        <div class="back">
            
        </div>
        <div class="content">
            <h3>About Us ...</h3>
            <p>Welcome to Ignite, your go-to destination for premium motorbike spare parts. 
                Fueled by a <br>deep love for motorcycles, we're dedicated to enhancing your riding experience with a 
                carefully <br>curated selection of high-quality components. Whether you're a seasoned rider or embarking on
                 <br>your first journey, trust Ignite for reliable, precision-engineered parts that ensure every ride <br>
                 is an exhilarating adventure. Gear up with confidence  Ignite, where quality meets passion.</p>
            <a href="shop.php" class="btn">shop now</a>

        </div>
    </section>
    <section class="reveiw" id="reveiw">
        <h1 class="heading"> CUSTOMER<span> REVIEWS</span></h1>
        <div class="box-container">
        <?php
    $select_products = mysqli_query($connect, "SELECT * FROM review ORDER BY rId desc");
    if(mysqli_num_rows($select_products) > 0){
        while($row = mysqli_fetch_assoc($select_products)){
    ?>
    <div class="box">
        <img src="images\customers.png" alt="">
        <h3><?php echo $row['reviewerName']; ?></h3>
        <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
        </div>
        <div class="content">
            <p><?php echo $row['review']; ?></p>
        </div>
    </div>
    <?php
        };    
    };
    ?>
</div>
        </div>
      </section>
      <section class="steps" id="steps">
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
  </body>  
</html>