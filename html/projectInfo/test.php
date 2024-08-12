<?php
//database configuration

define('server', 'localhost');
define('username', 'root');
define('password', '');
define('database', 'Eshop');
 
$link = mysqli_connect(server, username, password, database); //log in to the database
if (!$link) {
    die("Connection failed: ". mysqli_connect_error());
    echo "Error: Failed to establish a connection with the database.";
}

$sql = "CREATE TABLE IF NOT EXISTS cart 
(
    OrderID bigint(8) unsigned auto_increment,
    ProductID bigint (8),
    size bigint(8),
    paid varchar(30),
    PRIMARY KEY (OrderID)
)"; //just in case the shopping cart wasn't already created, it will be created again. 

$result = mysqli_query($link, $sql) or die("Connection failed2: ".mysqli_connect_error());

$ID =  $_GET['item'];
$val = $_POST['number'];
$stat = "no";

$query = "SELECT * FROM cart WHERE ProductID = '".$ID."'"; //fetch all items matching $ID
$result = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
$row = mysqli_fetch_array($result); //put results into an array

if(empty($row)) //executed if this item is being added to cart for the first time. 
{
    $query = "INSERT INTO cart (ProductID, size, paid) VALUES ('".$ID."', '".$val."', '".$stat."')";
    $result = mysqli_query($link, $query) or die("Connection failed2: ".mysqli_connect_error());

    if($result){
        header("Location: ../shopping_cart.php?action=added");
    }
}
else { //executed if this item is already in cart. In this case, only the number of items is modified on the table

    $val = $val + $row['size']; //add current value to the value given as input

    $query = "UPDATE cart 
        SET size = $val
    WHERE ProductID = $ID";

$result = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
}


if($result){
    header("Location: ../shopping_cart.php?action=added"); //redirect to shopping cart and get message that item was added
}

?>