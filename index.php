<?php 
include_once 'includes/dbh.php';
define('DIR_INCLUDES', 'includes/');
define('DIR_TEMPLATES', 'template/');
define('DIR_PUB', 'public/');
define('DIR_CSS', DIR_PUB . 'css/');
define('DIR_IMG', DIR_PUB . 'slike/');


   
$stranica = $_GET['stranica'] ?? '';
       
       

switch ($stranica) {
    case '' :
		$stranica = 'body';
    case 'isplanirajObrok' ;
    case 'nabavkaNamirnica';
    case 'kontakt';
    case 'signIn';
    case 'register';
    case 'dodajRecept';
    case 'adminFormHandling';
        $pozovi = DIR_INCLUDES."$stranica.php";
        if(!file_exists("$pozovi"))
            $pozovi = DIR_INCLUDES."greska404.php";
        break;
	default :
		$pozovi = DIR_INCLUDES.'greska404.php';
		break;
}


include_once(DIR_TEMPLATES.'header.php'); 
include($pozovi);    
include_once(DIR_TEMPLATES.'footer.php') ;


?>
  
