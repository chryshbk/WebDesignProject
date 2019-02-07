<!DOCTYPE html>

<html>
    <head>
        <title>WP Eatery - Contact Us</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href='http://fonts.googleapis.com/css?family=Fugaz+One|Muli|Open+Sans:400,700,800' rel='stylesheet' type='text/css' />
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
         <?php
        try {
            $servername = '127.0.0.1';
            $username = 'wp_eatery';
            $password = 'password';
            $dbname = 'wp_eatery';

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $hasError = false;

            $errorMessage = Array();


            if (isset($_POST['btnSubmit'])) {
                if ($_POST['customerName'] == null) {
                    $errorMessage['customerNameError'] = "Please enter a customer name.";
                    $hasError = true;
                }

                if (!is_numeric($_POST['phoneNumber']) || $_POST['phoneNumber'] == null) {
                    $errorMessage['phoneNumError'] = "Please enter a numeric phone number.";
                    $hasError = true;
                }
                $phone = $_POST['phoneNumber'];
                if (!preg_match("/^\(?(\d{3})\)?[-\. ]?(\d{3})[-\. ]?(\d{4})$/", $phone)) {
                    $errorMessage['phoneNumError'] = "Invalid phone number. Please enter a correct format.";
                    $hasError = true;
                }

                if ($_POST['emailAddress'] == null) {
                    $errorMessage['emailAddError'] = "Please enter an email.";
                    $hasError = true;
                }
                if (!filter_var($_POST['emailAddress'], FILTER_VALIDATE_EMAIL)) {
                    $errorMessage['emailAddError'] = "Invalid email address. Please enter a correct format.";
                    $hasError = true;
                }

                if (!(isset($_POST['referral']))) {
                    $errorMessage['referralError'] = "Please select the referral.";
                    $hasError = true;
                }

                $customerName = $_POST['customerName'];
                $phoneNumber = $_POST['phoneNumber'];
                $emailAddress = $_POST['emailAddress'];
                $referral = $_POST['referral'];

                $check = mysqli_query($conn, "SELECT * FROM mailinglist WHERE emailaddress='$emailAddress' OR customername = '$customerName' AND phonenumber = '$phoneNumber'");
                if (mysqli_num_rows($check) > 0) {
                    echo "User already exists in the database.";
                    $hasError = true;
                }
                if (!$hasError) {

                    $insertQuery = "INSERT INTO mailinglist (customerName, phoneNumber, emailAddress, referrer) VALUES ('" . $customerName . "', '" . $phoneNumber . "', '" . password_hash($emailAddress, PASSWORD_DEFAULT) . "', '" . $referral . "')";

                    if ($conn->query($insertQuery) === TRUE) {
                        echo "New record created successfully";
                    } else
                        echo "Error: " . $insertQuery . "<br>" . $conn->error;
                }
                $conn->close();
            }
        }catch(Exception $e){
            //If there were any database connection/sql issues,
            //an error message will be displayed to the user.
            echo '<h3>Error on page.</h3>';
            echo '<p>' . $e->getMessage() . '</p>';            
            }

        ?>
        
        <div id="wrapper">
           <?php include 'header.php'; ?>
            <div id="content" class="clearfix">
                <aside>
                        <h2>Mailing Address</h2>
                        <h3>1385 Woodroffe Ave<br>
                            Ottawa, ON K4C1A4</h3>
                        <h2>Phone Number</h2>
                        <h3>(613)727-4723</h3>
                        <h2>Fax Number</h2>
                        <h3>(613)555-1212</h3>
                        <h2>Email Address</h2>
                        <h3>info@wpeatery.com</h3>
                </aside>
                
                <div class="main">
                    <h1>Sign up for our newsletter</h1>
                    <p>Please fill out the following form to be kept up to date with news, specials, and promotions from the WP eatery!</p>
                    <form name="frmNewsletter" id="frmNewsletter" method="post" action="contact.php" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td>Name:</td>
                                <td><input type="text" name="customerName" id="customerName" size='40'>
                                 <?php 
                                    if(isset($errorMessage['customerNameError'])){
                                    echo '<span style=\'color:red\'>' . $errorMessage['customerNameError'] . '</span>';
                                    }
                                 ?></td>
                            </tr>
                            <tr>
                                <td>Phone Number:</td>
                                <td><input type="text" name="phoneNumber" id="phoneNumber" size='40'>
                                    <?php 
                                    if(isset($errorMessage['phoneNumError'])){
                                    echo '<span style=\'color:red\'>' . $errorMessage['phoneNumError'] . '</span>';
                                    }
                                 ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Email Address:</td>
                                <td><input type="text" name="emailAddress" id="emailAddress" size='40'>
                                    <?php 
                                    if(isset($errorMessage['emailAddError'])){
                                    echo '<span style=\'color:red\'>' . $errorMessage['emailAddError'] . '</span>';
                                    }
                                 ?>
                                </td>
                            </tr>
                            <tr>
                                <td>How did you hear<br> about us?</td>
                                <td>Newspaper<input type="radio" name="referral" id="referralNewspaper" value="newspaper">
                                    Radio<input type="radio" name='referral' id='referralRadio' value='radio'>
                                    TV<input type='radio' name='referral' id='referralTV' value='TV'>
                                    Other<input type='radio' name='referral' id='referralOther' value='other'>
                                    <?php
                                    if (isset($errorMessage['referralError'])){
                                        echo '<span style=\'color:red\'>' . $errorMessage['referralError'] . '</span>';
                                    }
                                ?>
                            </tr>
                            <tr>
                                <td colspan='2'><input type='submit' name='btnSubmit' id='btnSubmit' value='Sign up!'>&nbsp;&nbsp;<input type='reset' name="btnReset" id="btnReset" value="Reset Form">
                                
                        </td>
                            </tr>
                        </table>
                        <input type="file" name="file"/>
                    </form>
                        <?php
                        $max_size = 3000000; //30KB
                        $location = 'files/'; //where the file is going
                        if (isset($_POST['btnSubmit'])) {
                            $name = $_FILES['file']['name']; //file name
                            $size = $_FILES['file']['size']; //file size
                            $type = $_FILES['file']['type']; //file type
                            $tmp_name = $_FILES['file']['tmp_name']; //temp location on server
                            if (checkType($name, $type) && checkSize($size, $max_size)) {
                                if (isset($name)) {
                                    save_file($tmp_name, $name, $location); //call my function
                                }
                            }
                        } else {
                            echo 'Please select a file:';
                        }
                        function checkType($name, $type)
                        {
                            return true;
                        }

                        function checkSize($size, $max_size)
                        {
                            if ($size <= $max_size) {
                                return true;
                            } else {
                                echo 'File is too large. Max size in 30KB.';
                                return false;
                            }
                        }

                        function fileExists($name)
                        {
                            $filename = rand(1000, 9999) . md5($name) . rand(1000, 9999);
                            echo $filename;
                            return false;
                        }

                        function save_file($tmp_name, $name, $location)
                        {
                            $og_name = $name;
                            //so long as the name is in existance - loop to check new name after it is generated
                            while (file_exists('uploads/' . $name)) {
                                echo 'File already exists. Generating name.<br/>';
                                $rand = rand(10000, 99999);
                                $name = $rand . '.' . pathinfo($name, PATHINFO_EXTENSION); //create new name
                            }
                            if (move_uploaded_file($tmp_name, $location . $name)) {
                                echo 'Success! ' . $og_name . ' was uploaded';
                                if (!($og_name == $name)) { //if original name != name
                                    echo ' and renamed to ' . $name . '.<br/>';
                                } else {
                                    echo '.';
                                }
                            } else {
                                echo 'ERROR!';
                            }
                        }
                        ?>

                </div><!-- End Main -->
            </div><!-- End Content -->
        <?php include 'footer.php'; ?>