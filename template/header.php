<?php 
session_start();
$dodajRecept = "";

//signIn/signOut
function logToggle(){
    if(isset($_SESSION['korisnik_id'])){?>

        <form method= "post" action="./index.php"><button type='submit' name='signOut' class='nav-link log'>Sign out</button></form>
    <?php
    }else{?> 
        <form method= "post" action="./index.php?stranica=signIn"><button type='submit' name='signIn'  class='nav-link log'>Sign in </button></form>
    <?php
    }
}

//ukoliko je kliknuto dugme za signOut prekini sesiju
if(isset($_POST['signOut'])){
    session_unset();
    session_destroy();
}

//ukoliko postoji sesija izmeni sadrzaj
if(isset($_SESSION['korisnik_id'])){
    $dodajRecept = "Dodaj recept";

}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>Fast meal</title>
    <!-- Bootstrap CSS -->
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
       
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    
    <link rel="stylesheet" href="/<?= DIR_CSS . 'style.css' ?>">
  </head>
  
    <body>
        <header>
            <nav id="mainNavbar"class="navbar  navbar-expand-md py-0 py-md-1 fixed-top">
                <a  href="./index.php" class="navbar-brand">FAST MEAL</a>
                <button class="navbar-toggler px-0" data-toggle="collapse" data-target="#navLinks" aria-label="Toggle navigation">
                    <img id="hamburger" src="<?= DIR_IMG . 'hamburger4.png' ?>" alt="">
                </button>

                <div class="collapse navbar-collapse" id="navLinks">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="./index.php?stranica=isplanirajObrok" class="nav-link">Isplaniraj obrok</a>
                        </li>
                        <li class="nav-item">
                            <a href="./index.php?stranica=nabavkaNamirnica" class="nav-link">Nabavka namirnica</a>
                        </li>
                        <li class="nav-item">
                            <a href="./index.php?stranica=kontakt" class="nav-link">Kontakt</a>
                        </li>
                        <li class="nav-item">
                            <a href="./index.php?stranica=dodajRecept" class="nav-link"><?php echo $dodajRecept ?></a>
                        </li> 
                        <li class="nav-item">
                        <?php logToggle();?>
                        </li>

                    </ul>
                    <form id="searchForm" class="d-flex align-items-center ml-auto my-1">
                    <input class="form-control mr-2 " type="search" placeholder="Search" aria-label="Search">
                    <button class="my-0 " type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </header>
