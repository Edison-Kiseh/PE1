<?php
    $address;
    /*echo("<h1>Your order has been placed, it will be shipped to the following address: " . $address . "</h1>");*/

    define('server', 'localhost');
    define('username', 'root');
    define('password', '');
    define('database', 'Eshop');
     
    $link = mysqli_connect(server, username, password, database);
    
    if (!$link) {
        die("Connection failed: ". mysqli_connect_error());
        echo "Error: Failed to establish a connection with the database.";
    }          
?>


<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="../css/reset.css" rel="stylesheet" />
        <link href="../css/style.css" rel="stylesheet"/>
        <link href="../css/popup.css" rel="stylesheet"/>
        <link href="../css/process.css" rel="stylesheet"/>
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery.color.plus-names.js"></script>
        <title>Order Confirmation</title>
        <script>

           $(document).ready(function(){
            $("#details").css("filter", "blur(20px)");
                $("#popup").hide();
                var i = 1;
                var j = 1;
                var interval;
                for(i = 1; i < 6; i++){
                    $("#dot" + i).hide();
                }
                /*for(j = 1; j < 6; j++){
                    interval = setInterval(function(){
                        $("#dot" + j).show();
                    }, 1000);
                }*/
                setTimeout(function(){
                    $("#dot1").show();
                }, 1000);
                setTimeout(function(){
                    $("#dot2").show();
                }, 2000);
                setTimeout(function(){
                    $("#dot3").show();
                }, 3000);
                setTimeout(function(){
                    $("#dot4").show();
                }, 4000);
                setTimeout(function(){
                    $("#dot5").show();
                }, 5000);

                setTimeout(function(){
                    $(".wrapper").hide();
                    $("#popup").show();
                    $("#cancel").click(function(){
                    $("#popup").hide();
                    $("#details").css("filter", "blur(0px)");

                });
                }, 6000);
           });

        
       </script>
    </head>
<body>
    <div class="background">
        <div class="navbar">
                <a href="./index.php"><img src="../images/logo2.png" class="logo"></a>
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
        
        <div class="wrapper">
            <div class="pro">
                <h1>Processing</h1>
            
                <img src="../images/dot.png" alt="dot" id="dot1" class="dotimage"/>
                <img src="../images/dot.png" alt="dot" id="dot2" class="dotimage"/>
                <img src="../images/dot.png" alt="dot" id="dot3" class="dotimage"/>
                <img src="../images/dot.png" alt="dot" id="dot4" class="dotimage"/>
                <img src="../images/dot.png" alt="dot" id="dot5" class="dotimage"/>
            </div>
            
            <p class="order">Your order is being processed. This will take a few seconds</p>

        </div>

        <div id="popup">
            <div>
                <img src="../images/x.png" alt="cancel" style="width: 25px; margin-left: 440px; margin-top: 10px;" id="cancel">
            </div>
            <div class="info">
                <h1 style="width: 400px; margin-left: 28px; font-size: 20px; margin-top: 20px;">Your order has been placed successfully and shipping is to be done shortly</h1>
                <p style="margin-top: 30px;">Thank you for choosing project space!</p>
            </div>
            <div class="image">
                <img src="../images/check-green.gif" alt="green checkmark" class="check"/>
            </div>
        </div>
        
        <div id="details" >
        <?php 
            $data = array();

                    
            $query = "SELECT * FROM cart  WHERE paid = 'yes'"; //select all paid items

            $result = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
            $numbers = mysqli_num_rows($result);

            $query = "SELECT * FROM products";
            $result2 = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
            $numbers2 = mysqli_num_rows($result2);

            $query = "SELECT * FROM Customers";
            $result3 = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
            $numbers3 = mysqli_num_rows($result3);

            if($numbers == 0)
            {
                echo("<div class=\"content\">");
                echo("<div class=\"h1\">Orders</div>");
                echo("<p>You haven't mader any orders yet, visit our project page and browse our exciting projects.</p>");
                echo("<a href=\"../html/shop.html\" style=\"color: grey\" class=\"back\"><p>Back to shop</p></a>");
                echo("</div>");
            }
            else{
                echo("<p class=\"cartm\" style=\"text-align: center; font-size: 40px; margin-top: 57px; margin-bottom: 20px; font-weight: bolder;\">Your Orders</p>"); 
                echo("<a href=\"../html/shop.html\" style=\" text-align: center; font-size: large;\" class=\"back\"><p>Back to Shopping</p></a>");
                 
                echo("<p style=\"font-size: 21px; margin-left: 342px; margin-top: 60px;\">Number of customers: " . $numbers3 . " <p>");
                while ($customer = mysqli_fetch_array($result3)) {
                    $data = $customer['Orders'];
                    $udata = unserialize($data);
                    $size = count($udata);
                    
                    

                    echo("<div id=\"cartdisp\">");
                    echo("<div style=\"width: 55%; margin-top: 40px; margin-left: auto; margin-right: auto; border-bottom: 2px solid black; background-color: #f8f8f8; color: black; padding: 16px\">");
                    echo("<p style=\"font-size: 30px; font-weight: bold; margin-bottom: 20px\">Order(s) made by: " . $customer['Firstname'] . " " . $customer['Lastname'] . "</p>");
                    echo("<hr>");
                
                    for ($i = 0; $i < $size; $i++) {

                        $query = "SELECT * FROM cart WHERE paid = 'yes' AND OrderID = '".$udata[$i]."'";
                        $res = mysqli_query($link, $query) or die("Error: an error has occurred while executing the query!");
                        $cart = mysqli_fetch_array($res);
                        $length1 = mysqli_num_rows($res);
                        
                        if($length1)
                        {
                                                    
                            $prod =  $cart['ProductID'];
                            $query = "SELECT * FROM products WHERE ID = '".$prod."'";
                            $result4 = mysqli_query($link, $query) or die("Error: an error has occurred while executing the query!");
                            $row2 = mysqli_fetch_array($result4);
                            $length2 = mysqli_num_rows($result4);
                            
                            if($length2)
                            {
                                echo("
                                <div style=\"display: flex\">
                                <p><img src=\"".$row2['Imagesource']."\" class=\"cartimg\" style=\"width: 250px; height: 230px; margin-right: 40px;\"></p>
                                    <div>
                                        <p style=\"font-size: 22px;\"><b>Item name:</b> " .$row2['Projectname']. "</p><br />
                                        <p style=\"font-size: 22px;\"><b>Price per item: </b>&euro;".$row2['Price']."</p><br />
                                        <p style=\"font-size: 22px;\"><b>Quantity: </b>
                                        ".$cart['size']."
                                        </p>
                                    </div>
                                </div>
                                <hr>
                            ");
                            }

                        }
                    }
                
                    echo("</div>");
                    echo("</div>");
                }
                
            }
            ?>

        </div>

        <footer style="margin-top: 200px">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <h2>QUICK LINKS</h2>
                        <a href="../html/contact.html"><p>Contact us</p></a>
                        <p>About</p>
                        <a href="../html/shippingpolicy.html"><p>Shipping policy</p></a>
                        <a href="../html/refundpolicy.html">Refund policy</a>
                        <a href="../html/termsofservice.html"><p>Terms of service</p></a>
                        <a href="../html/privacypolicy.html"><p>Privacy policy</p></a>
                    </div>
                    <div class="col-sm-4">
                        <h2>CONTACT US</h2>
                        <a href="mailto:r0937121@student.thomasmore.be"><p>r0937121@student.thomasmore.be</p></a>
                        <p>or</p>
                        <a href="mailto:r0909304@student.thomasmore.be"><p>r0909304@student.thomasmore.be</p></a>
                    </div>
                    <div class="col-sm-4">
                        <h2>NEWSLETTER</h2>
                        <p>Exclusive offers, promotions, deals and discounts from our store</p>
                        <p><input type="text" id="subscribe" name="subscribe" value="Enter your email" class="text" /></p>
                        <p><input type="submit" value="Submit" class="submit"/></p>
                    </div>
                </div>
                <div class="socials">
                    <h2>FOLLOW US:</h2>
                    <div class="logos">
                        <a href="https://www.facebook.com/edison.kiseh" target="_blank"><img src="../images/facebook_logo.png" alt="facebook"/></a>
                        <a href="https://www.instagram.com/the_awesome_lord/" target="_blank"><img src="../images/instagram_logo.png" alt="instagram"/></a>
                        <a href="https://twitter.com/theawesomelord4/" target="_blank"><img src="../images/twitter_logo.png" alt="twitter"/></a>
                        <a href="https://www.youtube.com/@projectengineering" target="_blank"><img src="../images/youtube_logo.png" alt="youtube"/></a>
                        <a href="https://discord.gg/sjv6z833ev" target="_blank"><img src="../images/discord_logo.png" alt="discord" /></a>
                    </div>
                </div>
                <hr>
                <div class="copyright">Copyright &copy; Thomas More Mechelen-Antwerp vzw - Campus De Nayer - Professional bachelor electronics-ict - 2023</div>
            </div>
            
        </footer>
    </div>
</body>
</html>
