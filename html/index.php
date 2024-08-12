<?php
//database configuration
define('server', 'localhost');
define('username', 'root');
define('password', '');
define('database', 'Eshop');
 
$link = mysqli_connect(server, username, password);

if (!$link) {
    die("Connection failed: ". mysqli_connect_error());
   echo "Error: Failed to establish a connection with the database.";
}


  // Create database
  $sql = "CREATE DATABASE IF NOT EXISTS Eshop"; //create database anew if not already present
  if ($link->query($sql) === FALSE) 
  {
    echo "Error creating database: " . $link->error;
  }

 $link = mysqli_connect(server, username, password, database); //connect to the database you just created

 if (!$link) {
    die("Connection failed: ". mysqli_connect_error());
   echo "Error: Failed to establish a connection with the database.";
}


  $fill = 0;  //local variable to determine whether to fill up table
  // Check if the table exists
  $table_name = "products";
  $query = "SHOW TABLES LIKE '".$table_name."'";
  $result = mysqli_query($link, $query);

  if(mysqli_num_rows($result) > 0 ) {
      $query = "SELECT * FROM products";
      $result2 = mysqli_query($link, $query);

      if(mysqli_num_rows($result2) == 1 )
      {
        $fill = 1;
      }
  } 
  else{
    $fill = 1; 
  }

  if($fill)
  {
        //create the primary table with all the products to be seen throughought the webshop
        $query = "CREATE TABLE IF NOT EXISTS Products 
        (
            ID bigint(8) unsigned auto_increment,
            Projectname varchar (32),
            Price int (4),
            Imagesource varchar (32),
    
            PRIMARY KEY (ID)
        )";
    
        $result = mysqli_query($link, $query) or die("Error: a second error has occured while executing the query!");

        $query = "INSERT INTO Products (Projectname, Price, Imagesource) VALUES ('Sound sensor', 5.99, '../images/pic1.jpg')";
        $result = mysqli_query($link, $query) or die("Error: a second error has occured while executing the query!");
        $query = "INSERT INTO Products (Projectname, Price, Imagesource) VALUES ('Analog dial', 4.99, '../images/pic2.jpg')";
        $result = mysqli_query($link, $query) or die("Error: a second error has occured while executing the query!");
        $query = "INSERT INTO Products (Projectname, Price, Imagesource) VALUES ('Robot arm', 9.99, '../images/pic3.jpg')";
        $result = mysqli_query($link, $query) or die("Error: a second error has occured while executing the query!");
        $query = "INSERT INTO Products (Projectname, Price, Imagesource) VALUES ('Light dimmer', 3.99, '../images/pic4.jpg')";
        $result = mysqli_query($link, $query) or die("Error: a second error has occured while executing the query!");
        $query = "INSERT INTO Products (Projectname, Price, Imagesource) VALUES ('Bar graph', 7.99, '../images/pic5.jpg')";
        $result = mysqli_query($link, $query) or die("Error: a second error has occured while executing the query!");
        $query = "INSERT INTO Products (Projectname, Price, Imagesource) VALUES ('Running lights', 5.99, '../images/pic6.jpg')";
        $result = mysqli_query($link, $query) or die("Error: a second error has occured while executing the query!");
        $query = "INSERT INTO Products (Projectname, Price, Imagesource) VALUES ('Audio visualizer', 8.99, '../images/pic7.jpg')";
        $result = mysqli_query($link, $query) or die("Error: a second error has occured while executing the query!");
        $query = "INSERT INTO Products (Projectname, Price, Imagesource) VALUES ('Arduino Radar', 16.99, '../images/pic8.jpg')";
        $result = mysqli_query($link, $query) or die("Error: a second error has occured while executing the query!");

  }

 
  $IR_RECEIVE_PINquery = "CREATE TABLE IF NOT EXISTS Customers
  (
      ID bigint(8) unsigned auto_increment,
      Firstname varchar (50),
      Lastname varchar (50),
      Email varchar (50),
      Phone varchar(16),
      Orders TEXT,
      ShippingAddress varchar (200),
  
  
      PRIMARY KEY (ID)
  )";  
  

  $result = mysqli_query($link, $query) or die("Error: a second error has occured while executing the query!");
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="../css/reset.css" rel="stylesheet" />
        <link href="../css/style.css" rel="stylesheet"/>
        <link href="../css/index.css" rel="stylesheet" />
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery.color.plus-names.js"></script>
        <title>HOME</title>

        <script>
            
        var array = ["../images/pic3.jpg", "../images/pic4.jpg", "../images/pic5.jpg", "../images/pic6.jpg", "../images/pic7.jpg", "../images/pic8.jpg" ];
        var slides;

        var i = 0;

        function verify()
        {
            var email = document.getElementById('subscribe').value;

            const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;//copied this line and the following one from the internet in order to validate my email
            var test = regex.test(email);
  
            if(test)
            {
                alert('You are now subscribed to our news letter!\nCheck your emails regularly for our exclusive deals!');
            }

            if(!test)
            {
                document.getElementById('subscribe').value = "Please enter a valid email"
            }
     
            
        }


            $(document).ready(function(){
                $(".background").hide();
                $(".slogan").hide();
                $(".navbar ul li").hide();
                $(".background").fadeIn(800);
                $(".slogan").slideDown(1800); 

                $(".navbar ul li").slideDown(2000);

            });

            function load(){
                slides = document.getElementById('slideshow');
            }
            function showSlide(){
                slides.src = array[i];
                i++;
                if(i >= array.length)
                {
                    i = 0;
                }
            }
        
            function startSlideShow()
            {
            setInterval(showSlide, 2000);
            clearInterval(showSlide, 2000);
            }
        </script>
    </head>
<body onload="load(), startSlideShow()" >
    <div class="background" style="background-image: linear-gradient(rgba(0, 0, 0, 0.2),rgba(0,0,0,0.4)),url(../images/space.jpg);">
        <div class="navbar">
            <img src="../images/logo2.png" class="logo">
            <ul>
                <li><a href="../html/shop.html">SHOP</a></li>
                <li><a href="#">ABOUT</a>
                    <ul class="dropdown">
                        <a href="../html/aboutprojectspace.html"><li>PROJECT SPACE</li></a>
                        <a href="../html/aboutus.html"><li>THE TEAM</li></a>
                    </ul>
                </li>
                <li><a href="../html/contact.html">CONTACT</a></li>
            </ul>
        </div>
        <div class="content" style="display: flex; justify-content: space-between;">
            <div>
                <h1>Project Space</h1>
                <p class="slogan">As much as there are stars in the sky,</p>
                <p class="slogan">so are the projects we provide</p>
                <a href="../html/shop.html">
                <button>
                    <span>Shop now</span>
                </button>
                </a>
            </div>
            <div>
                <img src="../images/pic2.jpg" alt="slideshow" style="width: 300px; height: 300px; border: 10px ridge gray; margin-right: 100px;" id="slideshow"/>
            </div>
        </div>
    
    </div>
</body>
</html>
