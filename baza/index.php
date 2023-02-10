<?php
    include_once 'includes/dbh.php';
    session_start(); // to stavljas na vrhu hedera da bi se ukljicivalo na svakoj strani
?>
<html>

    <head>
        <title>Home</title>
    </head>

    <body>

    <!--"action" is a path to a file that i want to run after i click submit button-->
    <form action="includes/signup.php" method="POST">
    
        <input type="text" name="first" placeholder="Firstname">
        <br>
        <input type="text" name="last" placeholder="Lastname">
        <br>
        <input type="text" name="email" placeholder="Email">
        <br>
        <input type="text" name="uid" placeholder="Username">
        <br>
        <input type="password" name="pwd" placeholder="Password">
        <br>
        <button type="submit" name="submit">Sign up</button>

    </form>

    <?php 

    if(isset($_SESSION['u_uid'])){ //ukoliko je ulogovan prikazi "log out"
       echo' <form action="includes/logout.php" method="POST">
        <button type="submit" name="submit">Log out</button>
        </form>';
    }else{ //ukoliko nije ulogovan prikazi mu log in
        echo'<form action="includes/login.php" method="POST">
                <input type="text" name="uid" placeholder="Username">
                <input type="password" name="pwd" placeholder="Password">
                <button type="submit" name="submit">Log in</button>
            </form>';
    }
    ?>



    <?php
        if(isset($_SESSION['u_id'])){
            echo $_SESSION['u_uid']; //pomocu te sesije ces isto uraditi i za recepte
        }
    ?>
        
    <footer>

    </footer>
    </body> 

</html>
