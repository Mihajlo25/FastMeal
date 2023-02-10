<?php 
$user = $psw = "";
$user_error = $psw_error = "";
if(isset($_POST['submit'])){
    
    include 'dbh.php';
    

    //USER
    if(empty($_POST['user'])){
        
        $user_error = "Potrebno je popuniti polje";
        
    }else{
       
        $user = mysqli_real_escape_string($konekcija,$_POST['user']);
        
        $sql = "SELECT * FROM korisnici WHERE korisnicko_ime='$user' OR email='$user'";
        $result = mysqli_query($konekcija,$sql);
        $resultCheck = mysqli_num_rows($result);

        //proveri da li ima usera u bazi
        
        if($resultCheck==0){//nepostoji
            $user_error = "Ne postoji takav korisnik.";
        }else{  //postoji
               
                if(empty($_POST['psw'])){
                    $psw_error = "Potrebno je popuniti polje";
                }else{
                    $psw = $_POST['psw'];
                    //mysqli_fetch_assoc - Returns an associative array that corresponds to the fetched row or NULL if there are no more rows.
                    $row = mysqli_fetch_assoc($result);                  
                    if(!password_verify($psw,$row['sifra'])){
                        $psw_error = "Pogresna sifra!";
                    }else{
                        $psw_error = "";
                    }
                   
                }
            
        }
    }
    if($user_error == "" && $psw_error == ""){
        $_SESSION['korisnik_id'] = $row['korisnik_id'];
        $_SESSION['korisnicko_ime'] = $row['korisnicko_ime'];
        header('location: ./index.php');
    }
}

?>
<div id="logIn" class="row justify-content-center mx-0">
    <form id="formLogIn" action= "<?php $_SERVER['PHP_SELF']; ?>" method = "post" >
        <div class="row justify-content-center">
            <h2 class="col-8 pl-5">Sign in</h2>
        </div>
        <div class="row s justify-content-center">
            <div class="col-3">
                <label for="user" >User: </label>
            </div>
            <div class="col-8">
            <input type="mail" id="user" name="user" placeholder="Username/Email"></br>
            <span class = "error"><?php echo $user_error ?></span>
            </div>      
        </div>
        <div class="row s justify-content-center">
            <div class="col-3">
                <label for="psw" >Password: </label>
            </div>
            <div class="col-8">
            <input type="password" id="psw" name="psw" placeholder="Password"></br>
            <span class = "error"><?php echo $psw_error ?></span>
            </div>      
        </div>
        <div class="row s justify-content-center pt-2">
            <div class="col-6 mt-1">
                <input id = "zapamti" type="checkbox" name="zapamti">
                <label for="zapamti"> Zapamti sifru?</label>     
            </div>
            <div id="btnParent" class="col-4">
                <input type="submit" class="btn" value="Log in" name="submit">
            </div>
        </div>
        <div class="row s justify-content-center">
            <div class="col-8">
                <p>Nemate nalog?  <a href="./index.php?stranica=register">Register</a></p>
            </div>
        </div>
    </form>
</div>


