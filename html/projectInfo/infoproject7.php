<?php
//database configuration
define('server', 'localhost');
define('username', 'root');
define('password', '');
define('database', 'Eshop');
 
$link = mysqli_connect(server, username, password, database);

if (!$link) {
    die("Connection failed: ". mysqli_connect_error());
    echo "Error: Failed to establish a connection with the database.";
}

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../../css/style.css" rel="stylesheet" />
    <link href="../../css/Infoproject.css" rel="stylesheet" />
    <link href="../../css/shop.css" rel="stylesheet" />
    <title>Project Information</title>

    <script>
        function verify(){
            var quantity = document.getElementById("number").value;
            if(quantity == "0" || quantity == "")
            {
                return false;
            }
            else{
                return true;
            }
        }
    </script>

</head>
<body>
    <div class="background">
        <div class="navbar">
        <a href="../index.php"><img src="../../images/logo2.png" class="logo"></a>
            <ul>
                <li><a href="../../html/shop.html">SHOP</a></li>
                <li><a href="#">ABOUT</a>
                    <ul class="dropdown">
                        <a href="../../html/aboutprojectspace.html"><li>PROJECT SPACE</li></a>
                        <a href="../../html/aboutus.html"><li>THE TEAM</li></a>
                    </ul>
                </li>
                <li><a href="../../html/contact.html">CONTACT</a></li>
            </ul>
        </div>
    </div>

        <div class="container" >
            <div class="row">
            <div class="col-3">
                    <img src="../../images/pic8.jpg" alt="project" class="project" style="height: 240px"/>
                </div>
                <div class="col-sm-6" style="padding: 0px 30px 0px 30px;">
                        <u><h1>Arduino Radar</h1></u>
                    <p class="h3">
                        Description
                    </p>
                    <br />
                    <p>
                       This is an arduino radar. This project consists of an ultrasonic sensor on a servo that turns around and the ultrasonic sensor reads the data around then this data is displayed in multiple ways, for example with LEDs and with an LCD. It is a personal favourite and is totally recommended!
                    </p>
                </div>
                <div class="col-sm-3">
                    <?php 
                        //Use GET request to fetch item from products matching the ID 

                        $num = $_GET['item'];

                        $query = "SELECT * FROM products WHERE ID = '".$num."'";
                        $result = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
                        $row = mysqli_fetch_array($result); //store results in an array called $row
                        echo("<form method=\"POST\" action=\"test.php?item=".$num."\" onsubmit=\"return verify()\"> ");
                            echo("<p class=\"h4\">Project ".$num."</p>");
                            echo("<p class=\"h5\"><b>".$row['Price']."€</b></p>");
                            echo("<p><label for=\"number\">Enter item quantity:</label><br>");
                            echo("<input type=\"text\" name=\"number\" id= \"number\" placeholder=\"Quantity\"></input></p>");
                            echo("<p>
                                    <input type=\"submit\" value=\"Add to cart\" class=\"button\" onclick=\"verify()\"></input> 
                                </p>");
                        echo("</form>");
                    ?> 
                </div>
            </div>
        </div>
    </div>
</body>
</html>