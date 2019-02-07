<!DOCTYPE html>
<html>
    <head>
        <title>WP Eatery - Menu</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href='http://fonts.googleapis.com/css?family=Fugaz+One|Muli|Open+Sans:400,700,800' rel='stylesheet' type='text/css' />
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <?php include 'header.php'; ?>
            
            <div id="content" class="clearfix">
                <aside>
                        <h2><?php echo date('l', time()).'\'s'?> Specials</h2>
                    
                    <?php 
                    include 'menuItem.php'; ?>
                     <hr>
                    <img src="images/burger_small.jpg" alt="Burger" title=" <?php echo date('l') ?>'s Special Burger">
                    
                    <?php
                    
                    $item1 = new menuItems('<h3>The WP Burger</h3>', '<p>Freshly made all-beef patty served up with homefries</p>',
                                          '$14');
                    echo $item1->getItemName();
                    echo $item1->getDescription(). 'Price: '.$item1->getPrice();
                    
                    echo '<hr>';
                    echo '<img src="images/kebobs.jpg" alt="Kebobs" title="WP Kebobs">';
                    
                    $item2 = new menuItems('<h3>WP Kebobs</h3>', '<p>Tender cuts of beef and chicken, served with your choice of side</p>','$17');
                    echo $item2->getItemName();
                    echo $item2->getDescription(). 'Price: '.$item2->getPrice();
                    
                    ?>
                    <hr>
                </aside>
                    
                <div class="main">
                    <h1>Welcome</h1>
                    <img src="images/dining_room.jpg" alt="Dining Room" title="The WP Eatery Dining Room" class="content_pic">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    <h2>Book your Christmas Party!</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                </div><!-- End Main -->
            </div><!-- End Content -->
            <?php include 'footer.php'; ?>
