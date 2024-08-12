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

    $del = 0;

    if(isset($_GET['change']) && isset($_GET['iden']))
    {
        $ident = $_GET['iden'];

        $query = "SELECT * FROM cart WHERE ProductID = $ident";
        
        $result = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");

        if(mysqli_num_rows($result) == 1)
        {
            $row = mysqli_fetch_array($result);
            $update = $row['size'];

            if($_GET['change'] == "plus")
            {
                $update = $update + 1;
            }
            else if($_GET['change'] == "minus")
            {
                $update = $update - 1;
            }


            if($update == 0 || $update < 1)
            {
                $query = "DELETE FROM cart WHERE ProductID = $ident";
                $result = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");

                $del = 1;
            }
            else
            {
                $query = "UPDATE cart SET size = $update WHERE ProductID = $ident";
                $result = mysqli_query($link, $query) or die("Error: an error has occured while executing the query!");
            }

            if($result){
                if($del)
                {
                    header("Location: shopping_cart.php?action=deleted");
                    exit();
                }
                else{
                    header("Location: shopping_cart.php");
                    exit();
                }
            }
        }


    }
?> 