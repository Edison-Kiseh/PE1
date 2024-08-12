<?php 
 define('server', 'localhost');
 define('username', 'root');
 define('password', '');
 define('database', 'Eshop');
  
 $link = mysqli_connect(server, username, password, database);
 
 if (!$link) {
     die("Connection failed: ". mysqli_connect_error());
     echo "Error: Failed to establish a connection with the database.";
 }          

 $sql="CREATE TABLE IF NOT EXISTS cart (OrderID bigint(8) unsigned auto_increment,
                                    ProductID bigint (8),
                                    size bigint(8),
                                    paid varchar(30),
                                    PRIMARY KEY (OrderID))";
 mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="../css/reset.css" rel="stylesheet" />
        <link href="../css/style.css" rel="stylesheet"/>
        <link href="../css/shopping_cart.css" rel="stylesheet" />
        <link href="../css/userdata.css" rel="stylesheet" />
        <script src="../js/jquery.js"></script>
        <script src="../js/jquery.color.plus-names.js"></script>
        <title>Cart</title>
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

        <?php 
            $sum = 0;
            $weight = 0;
            $price = 0;

            $query = "SELECT * FROM cart  WHERE paid = 'no'"; //select all unpaid items

            $result = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
            $numbers = mysqli_num_rows($result);

            $query = "SELECT * FROM products";
            $result2 = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
            $numbers2 = mysqli_num_rows($result2);



            if(isset($_GET['action'])) //executed when item is added to cart from the info page
            {
                if($_GET['action'] == "added")
                {
                    echo("<div class=\"h4\">");
                    echo("<p style=\"text-align: center\">Item was added succesfully!</p>");
                    echo("</div>");
                }

                if($_GET['action'] == "deleted")
                {
                    echo("<div class=\"h4\">");
                    echo("<p style=\"text-align: center\">Item was removed from shopping cart!</p>");
                    echo("</div>");
                }

            }


            if($numbers == 0)
            {
                echo("<div class=\"content\">");
                echo("<div class=\"h1\" class=\"h1\" style=\"text-align: center; margin: 50px 0px 30px 0px; font-size: 50px\">Cart</div>");
                echo("<p style=\"text-align: center; font-size: 25px; margin-bottom: 20px\">Looks like your shopping cart is currently empty...</p>");
                echo("<a href=\"../html/shop.html\" style=\"color: grey; text-align: center; font-size: 25px; margin-bottom: 20px;\" class=\"back\"><p>Back to shop</p></a>");
                echo("</div>");
            }
            else{
                echo("<p class=\"cartm\" style=\"text-align: center; font-size: 40px; margin-top: 57px; margin-bottom: 20px; font-weight: bolder;\">Your Cart</p>"); 
                echo("<a href=\"../html/shop.html\" style=\" text-align: center; font-size: large;\" class=\"back\"><p>Continue Shopping</p></a>");
                echo("<div id=\"cartdisp\">");
                echo("<table style=\"width: 95%; height: 300px; margin-top: 70px; margin-left: 40px; border-bottom: 2px solid black; background-color: #f8f8f8; color: black;\">");
                echo("<tr style=\"border-bottom: 2px solid black; font-size: 25px;\" ><th class=\"apart\"style=\"padding: 15px;\">Item</th><th class=\"apart\">Name</th><th class=\"apart\">Price</th><th class=\"apart\">Quantity</th></tr>");

                while($row = mysqli_fetch_array($result))
                {
                    $prod =  $row['ProductID'];
                    $query = "SELECT * FROM products WHERE ID = '".$prod."'"; 
                    $result3 = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
                    $row2 = mysqli_fetch_array($result3);


                    $price = $row2['Price'];
                    $weight= $row['size'];

                    $sum += $weight * $price;
                    
                    echo("<tr>
                    <td style=\"vertical-align: middle; border-bottom: 2px solid black; padding:20px 0px 20px 20px\"><img src=\"".$row2['Imagesource']."\" class=\"cartimg\" style=\"width: 250px; height: 280px;\"></td>
                    <td style=\"font-size: 23px; vertical-align: middle; border-bottom: 2px solid black; padding:20px 0px 20px 0px\">".$row2['Projectname']."</td>
                    <td style=\"font-size: 23px; vertical-align: middle; border-bottom: 2px solid black; padding:20px 0px 20px 0px\">&euro;".$row2['Price']."</td>
                    <td style=\"font-size: 23px; vertical-align: middle; border-bottom: 2px solid black; padding:20px 0px 20px 0px\">
                        <a class=\"button\" href=\"update_size.php?change=minus&iden=".$row['ProductID']."&hide=".$row['size']."\" style=\"border: 1px solid black; color: black; text-decoration: none; padding: 5px 9px 5px 9px; background-color: grey; margin-right: 10px;\">-</a> 
                        ".$row['size']."
                        <a class=\"button\" href=\"update_size.php?change=plus&iden=".$row['ProductID']."&hide=".$row['size']."\" style=\"border: 1px solid black; color: black; text-decoration: none; padding: 5px 8px 5px 8px; background-color: grey; margin-left: 10px;\">+</a>
                        
                    </td>
                    </tr>");

                }
                echo("<tr><td></td><td></td><td></td><td style=\"padding: 10px; font-size: 21px;\" ><b>Total: &euro;".$sum." </b></td></tr>");
                echo("</table>");

                echo("<a href=\"../html/userdata.html\"><input type=\"button\" value=\"Checkout\" style=\"width: 145px; height: 45px; font-size: 23px; margin-left: 1250px; margin-top: 20px;\"></a>");
                echo("</div>");

            }
            ?>
            
        <footer style="margin-top: 200px">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <h2>QUICK LINKS</h2>
                        <a href="../html/aboutprojectspace.html"><p>About</p></a>
                        <a href="../html/seemoreabout.html"><p>About us</p></a>
                        <a href="../html/contact.html"><p>Contact us</p></a>
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
