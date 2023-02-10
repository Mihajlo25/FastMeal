<?php 
    $email = $user = $psw = $repsw = "";
    $success = $email_error = $user_error = $psw_error = $repsw_error = "";
    if(isset($_POST['submit'])){
        include_once 'dbh.php'; //      ERROR 404 <<-----


        $email  = mysqli_real_escape_string($konekcija,$_POST['email']);
        $user   = mysqli_real_escape_string($konekcija,$_POST['username']);
        $psw    = mysqli_real_escape_string($konekcija,$_POST['psw']);

        if(empty($_POST['email'])){
            $email_error = "Potrebno je popuniti polje";
        }else{
            $email = $_POST['email'];

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){//proveri da li je validan mail
            $email_error =  "Nevalidan format mail-a";
            $email = "";
            }else{
                $sql = "SELECT * FROM korisnici WHERE email='$email'";
                $result = mysqli_query($konekcija,$sql);
                $resultCheck = mysqli_num_rows($result);
                

                if($resultCheck>0){//zauzet mail
                    $email_error = "Ovaj mail je zauzet";
                }else{
                    $email_error = "";
                }
            }
        }
    
        if(empty($_POST['username'])){
            $user_error = "Potrebno je popuniti polje";
        }else{
            $user = $_POST['username'];

            $sql = "SELECT * FROM korisnici WHERE korisnicko_ime='$user'";
            $result = mysqli_query($konekcija,$sql);
            $resultCheck = mysqli_num_rows($result);

            if($resultCheck>0){//zauzet mail
                $user_error = "Ovo korisnicko ime je zauzeto";
            }else{
                $user_error = "";
            }
        }
        
    
        if(empty($_POST['psw'])){
            $psw_error = "Potrebno je popuniti polje";
        }else{
            $psw = $_POST["psw"];
            if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{5,30}$/', $psw)) {
                $psw_error = "Šifra mora da ima makar jedno slovo i broj i minimum 5 kkaraktera!";
                $psw = "";
            }else{
                $psw_error = "";
            }
         }
          
    
        if(empty($_POST['repsw'])){
            $repsw_error = "Potrebno je popuniti ovo polje";
        } else {
            $repsw = $_POST["repsw"];
            if($repsw != $psw){
                $repsw_error = 'Šifre se ne poklapaju.';
                $repsw = "";
            }else{
                $repsw_error = "";
            }
        }

        //upisivanje korisnika u bazu

        if($email_error == "" && $user_error == "" && $psw_error == "" && $repsw_error=="" ){//problem-ne ulazi u if
            //hashing psw
            $hashedPsw = password_hash($psw, PASSWORD_DEFAULT);
            $sql =  "INSERT INTO korisnici (email,korisnicko_ime,sifra) VALUES('$email','$user','$hashedPsw');";
            mysqli_query($konekcija, $sql);
            $success = "Uspesno ste se registrovali";
            
        }
    }
?>

<!--ooooooo -->
<div id="logIn" class="row justify-content-center mx-0">
    <form id="formRegister" action= "<?php $_SERVER['PHP_SELF']; ?>" method = "post"> 
        <div class="row justify-content-center">
            <h2 class="col-8 pl-5">Register</h2>
        </div>

        <div class="row s justify-content-center">
            <div class="col-3">
                <label for="email" >Email: </label>
            </div>
            <div class="col-8">
            <input type="mail" id="email" name="email" placeholder="Vas email"></br>
            <span class = "error"><?php echo $email_error ?></span>
            </div>      
        </div>
        <div class="row s justify-content-center">
            <div class="col-3">
                <label for="username" >Username: </label>
            </div>
            <div class="col-8">
            <input type="mail" id="username" name="username" placeholder="Vas username"></br>
            <span class = "error"><?php echo $user_error ?></span>
            </div>      
        </div>
        <div class="row s justify-content-center">
            <div class="col-3">
                <label for="password" >Password: </label>
            </div>
            <div class="col-8">
            <input type="password" id="password" name="psw" placeholder="Password"></br>
            <span class = "error"><?php echo $psw_error ?></span>
            </div>      
        </div>
        <div class="row s justify-content-center">
            <div class="col-3">
                <label for="password" >Re-enter password: </label>
            </div>
            <div class="col-8">
            <input type="password" id="password" name="repsw" placeholder="Password"></br>
            <span class = "error"><?php echo $repsw_error ?></span>
            </div>      
        </div>
        <div class="row s justify-content-center">
            <div class = "col-9">
            <span class = "success"><?php echo $success ?></span></div>
        </div>
        <div class="row s justify-content-center pt-2">
            <div id="btnParent" class="col-8">
                <input type="submit" class="btn" value="Register" name="submit">
            </div>
        </div>

    </form>
</div>