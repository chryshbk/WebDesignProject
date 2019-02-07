<html>
<head>
    <title>WP Eatery - Contact Us</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Fugaz+One|Muli|Open+Sans:400,700,800' rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
    session_start();
    ?>
    <div id="wrapper">
    <?php include 'header.php'; ?>
    <div id="content" class="clearfix">
    <div class="main">
    <?php
    try {
        $mysqli = new mysqli("127.0.0.1", "wp_eatery", "password", "wp_eatery");

        if ($mysqli->connect_error) {
            echo "Connection failed: \n . $mysqli->connect_error.";
        }
        $errorMessage = Array();
        $hasError = false;

            if (isset($_POST['btnSubmit'])){
            if ($_POST['login'] == null) {
                $errorMessage['loginError'] = "Please enter a login.";
                $hasError = true;
            }
        if ($_POST['password'] == null) {
            $errorMessage['passwordError'] = "Please enter a password.";
            $hasError = true;
        }
            $username = $_POST['login'];
            $password = $_POST['password'];
            $query = "SELECT username, password, DATE_FORMAT(lastlogin, '%Y/%c/%d - %H:%i:%s') FROM adminusers WHERE username = ? AND password = ?";
            $smt = $mysqli->prepare($query);
            $smt->bind_param("ss", $username, $password);
            $smt->execute();
            $result = $smt->get_result();

           if ($result->num_rows == 1){
               $_SESSION['AdminID'] = 1;

               header("Location:mailing_list.php");
               return true;
                } else {
               $errorMessage['loginFailed'] = "Login invalid.";
               $hasError = true;
           }
        }
    } catch(Exception $e){
        //If there were any database connection/sql issues,
        //an error message will be displayed to the user.
        echo '<h3>Error on page.</h3>';
        echo '<p>' . $e->getMessage() . '</p>';
    }
    ?>
    <form name="login" method="post">
        <table>
                <tr>
                    <td>Login:</td>
                    <td><input type="text" name="login" id="login" size=\'30\'>
                    <?php
                    if(isset($errorMessage['loginError'])){
                        echo '<span style=\'color:red\'>' . $errorMessage['loginError'] . '</span>';
                    }
                    ?></td>
                </tr>
                    <tr>
                <td>Password: </td>
                        <td><input type="password" name="password" id="password" size=\'30\'>
                    <?php
                    if(isset($errorMessage['passwordError'])){
                        echo '<span style=\'color:red\'>' . $errorMessage['passwordError'] . '</span>';
                    }
                    ?></td>
            </tr>
            <tr>
                <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Login"></td>
                <td>
                    <?php
                    if (isset($errorMessage['loginFailed'])){
                        echo '<span style=\'color:red\'>' . $errorMessage['loginFailed'] . '</span>';
                    }
                    ?></td>
            </tr>

                </tr>
        </table>
    </form>
    </div>
    </div>
</html>