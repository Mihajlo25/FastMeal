<?php 

$ime_error = $prezime_error = $email_error = $poruka_error = ""; //Greske
$ime = $prezime = $email = $poruka = $poslatMail = ""; //Podaci

if($_SERVER['REQUEST_METHOD'] == "POST"){

    //ime
    if(empty($_POST['ime'])){
        $ime_error = "Potrebno je popuniti polje";
    }else{
        $ime = $_POST["ime"];
	    if(!preg_match("#(*UTF8)[[:alpha:]]#",$ime)){ //za ime i prezime proveri da li su samo slova
            $ime_error = "Dozvoljena su samo slova i razmak";
            $ime = "";
	    }
    }
    //prezime
    if(empty($_POST['prezime'])){
        $prezime_error = "Potrebno je popuniti polje";
    }else{
        $prezime = $_POST["prezime"];
	    if(!preg_match("#(*UTF8)[[:alpha:]]#",$prezime)){ //za ime i prezime proveri da li su samo slova
            $prezime_error = "Dozvoljena su samo slova i razmak";
            $prezime = "";
	    }
    }

    if(empty($_POST['email'])){
        $email_error = "Potrebno je popuniti polje";
    }else{
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){//proveri da li je validan mail
        $email_error =  "Nevalidan format mail-a";
        $email = "";
        }
    }
    
    if(!empty($_POST['poruka'])){
		$poruka_error = "Niste uneli vašu poruku.";
	} else {
        $poruka = $_POST['poruka'];
	}
	
	//slanje maila
	if($ime_error == "" && $prezime_error == "" && $email_error == ""){
			$mailZa = 'alexandar.bog@mail.com';
			$headers = 'From: '.$email;
			$msg = 'You recived a mail from: '.$ime.'.\n\n'.$poruka;
			$subject = $ime.' '.$prezime;

			//mail($mailZa,$subject,$msg,$headers);
			$ime = $prezime = $email = $poruka = $poslatMail = "";
			$poslatMail = 'Uspešno ste poslali email.';
	} 
	else {
		$poslatMail = "";
	}
	
}
      
?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 m-auto">
			<div class="contact-form ">
				<h1>Kontaktirajte nas</h1>
				<p class="hint-text">Ukoliko imate neko pitanje obratite nam se putem mail-a</p>
				<p class="success"><?= $poslatMail?></p>
				<form action = "<?php $_SERVER['PHP_SELF']; ?>" method="post" id = "forma">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="inputFirstName">Ime</label>
								<input type="text" class="form-control" id="ime" name= "ime" value="<?= $ime?>">
								<span class = "error"><?= $ime_error ?></span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="inputLastName">Prezime</label>
								<input type="text" class="form-control" id="prezime" name= "prezime" value="<?= $prezime?>">
								<span class = "error"><?= $prezime_error ?></span>
							</div>
						</div>
					</div>            
					<div class="form-group">
						<label for="inputEmail">Email</label>
						<input type="text" class="form-control" id="email" name= "email" value="<?= $email?>">
						<span class = "error"><?= $email_error ?></span>
					</div>
					<div class="form-group">
						<label for="inputMessage">Poruka</label>
						<textarea class="form-control" id="inputMessage" rows="5" name="poruka" ><?= $poruka?></textarea>
					</div>
					<div id ="btnParent">
					<input type="submit" class="btn" value="Posalji" name="submit">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>