<!DOCTYPE html>
<html>
    <?php session_start(); ?>
    <head>
        <title>WP Eatery - Menu</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href='http://fonts.googleapis.com/css?family=Fugaz+One|Muli|Open+Sans:400,700,800' rel='stylesheet' type='text/css' />
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php
        echo '<div id="wrapper">';
        include 'header.php';
        echo '<div id="content" class="clearfix">';
        echo '<div class="main">';
		
       try{   
           $mysqli = new mysqli("127.0.0.1", "wp_eatery", "password", "wp_eatery");
           
           if ($mysqli->connect_error){
               echo "Connection failed: \n . $mysqli->connect_error.";
                header ("location:./Lab11/contact.php");
           }
           if (!(isset($_SESSION['AdminID']))){
               header ('Location: userlogin.php');
           }

           $query = "SELECT customername, phonenumber, emailaddress, referrer FROM mailinglist";
           $result = $mysqli->query($query);
               echo '<form method="post">';
               echo '<table border=\'1\'>';
               echo '<tr><th>Customer Name</th><th>Phone Number</th><th>Email Address</th><th>Referral</th></tr>';
                while($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>'.$row['customername'].'</td>';
                        echo '<td>'.$row['phonenumber'].'</td>';
                        echo '<td>'.$row['emailaddress'].'</td>';
                        echo '<td>'.$row['referrer'].'</td>';
                        echo '</tr>';
                    }
           echo '</table>';
           echo '<br>';
           echo '<p>Session ID: ' . session_id() . '</p></br>';

           $queryAdmin = "SELECT adminid, username, lastlogin FROM adminusers";
           $resultAd = $mysqli->query($queryAdmin);

           if ($row2 = mysqli_fetch_assoc($resultAd)) {
               echo '<p>Admin ID: ' . $row2['adminid']. '</p><br>';
               echo '<p>Last Logged: '. $row2['lastlogin'].'</p><br>';
           }
           echo '<input type="submit" name="btnLogout" id="btnLogout" value="Logout">';
           echo '</form>';
       }catch(Exception $e){
            //If there were any database connection/sql issues,
            //an error message will be displayed to the user.
            echo '<h3>Error on page.</h3>';
            echo '<p>' . $e->getMessage() . '</p>';            
        }

        if (array_key_exists('btnLogout',$_POST)) {
            date_default_timezone_set('America/Toronto');
            date_default_timezone_get();

            $today = date("Y/m/d H:i:s", time());
            $adminid = 1;
            $sql = "UPDATE adminusers SET lastlogin = ? WHERE adminid = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $today, $adminid);
            $stmt->execute();

            session_unset();
            session_destroy();
            session_start();
            session_regenerate_id();
            header('Location: userlogin.php');
        }
        echo '</div>';
        echo '</div>';
        include 'footer.php';
        echo '</div>';
        ?>
    </body>
</html>
