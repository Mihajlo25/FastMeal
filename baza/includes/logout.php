<?php

if(isset($_POST['submit'])){
    session_start();//We need to have session running, in order to detroy it 
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}

?>