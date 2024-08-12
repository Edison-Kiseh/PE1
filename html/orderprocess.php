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

$fname = htmlspecialchars($_POST['fname']);
$lname = htmlspecialchars($_POST['lname']);
$email = htmlspecialchars($_POST['email']);
$tel   = htmlspecialchars($_POST['tel']);
$addr1  = htmlspecialchars($_POST['addr1']);
$addr2 = htmlspecialchars($_POST['addr2']);
$addr3 = htmlspecialchars($_POST['Province']);
$pcode = htmlspecialchars($_POST['code']);
$city  = htmlspecialchars($_POST['city']);

$stat = "yes";
$data = array();
$datanew = array();
$address = $addr1." ". $addr2.", ".$pcode.", ".$city.", ".$addr3.", Belgium";


$query = "CREATE TABLE IF NOT EXISTS Customers
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



$query = "SELECT * FROM cart WHERE paid = 'no'"; //fetch all unpaid items currently in cart
$results = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");


while($row = mysqli_fetch_array($results))
{
    $IDget = $row['OrderID'];
    $data[] = $row['OrderID'];

    $query = "UPDATE cart 
    SET paid = 'yes'
    WHERE OrderID = $IDget";

    $result = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
}

$sdata = serialize($data);

$query = "SELECT * FROM Customers WHERE Firstname LIKE '%$fname%' AND Lastname LIKE '%$lname%'";
$result = mysqli_query($link, $query);
$row = mysqli_num_rows($result);
$array = mysqli_fetch_array($result);


if(empty($row))
{
    $query = "INSERT INTO Customers (Firstname, Lastname, Email, Phone, Orders, ShippingAddress) VALUES ('".$fname."', '".$lname."', '".$email."', '".$tel."', '".$sdata."', '".$address."')";
    mysqli_query($link, $query) or die("Connection failed2: ".mysqli_connect_error());
}
else{
    $search = $array['ID'];
    $data2 = $array['Orders'];

    $udata = unserialize($data2);

    foreach($data as $i)
    {
        $udata[] = $i;
    }
    $sdata = serialize($udata);


    $query = "UPDATE Customers
        SET Orders = '$sdata' 
    WHERE ID = $search";
    mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
}

if($result){
    header("Location: orderconfirm.php?action=added"); //redirect to shopping cart and get message that item was added
}

?>