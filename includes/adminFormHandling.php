<br><br><br><br><?php
include 'dbh.php';
//  ADMINFORM HANDLING
if($_SESSION['korisnicko_ime'] == 'admin'){
    $id=$naziv = $opis = "";
    if(isset($_POST['promeni'])){
      $id    = $_POST['recept_id'];
      $naziv = $_POST['naziv'] ;
      $opis  = $_POST['opis'];
    }

    if(isset($_POST['promeni'])){
        //  ukoliko nema slike
        if ($_FILES['slika']['size'] == 0){
            $sql = "UPDATE recepti SET naziv = $naziv, opis = $opis WHERE recept_id = $id; ";
            echo $sql;exit;
            if (mysqli_query($konekcija, $sql)) {
                echo "Uspesno je izmenjen sadrzaj";
              } else {
                echo "Neuspesno je izmenjen sadrzaj" . mysqli_error($konekcija);
              }
        }
        //  Ukoliko ima slike
        else{
            $fileName    = $_FILES['slika']['name'];
            $fileTmpName = $_FILES['slika']['tmp_name'];
            $fileSize    = $_FILES['slika']['size'];
            $fileError   = $_FILES['slika']['error'];
        
            $ext = explode('.',$fileName);
            $fileExt = strtolower(end($ext)); //  uzimamo rec posle zadnje tacke tj tip fajla
        
            $allowed = array("jpg","jpeg","png");
        
            if(in_array($fileExt,$allowed)){
                if($fileError == 0){
                    $fileNameNew = uniqid('',true).".".$fileExt; // uniqid mu daje naziv na osnovu trenutnog vremena u milisekundama 
                    $fileDestination = "public/slike/".$fileNameNew;

                    $sql = "UPDATE recepti SET naziv = '$naziv', opis = '$opis', slika = '$fileDestination' WHERE recept_id = $id; ";
                    
                    if (mysqli_query($konekcija, $sql)) {
                        move_uploaded_file($fileTmpName,$fileDestination);
                        header("Location: index.php");
                      } else {
                        echo "Neuspesno je izmenjen sadrzaj" . mysqli_error($konekcija);
                      }
                    
                }else{
                    echo "Doslo je do greske prilikom aploudovanja vaseg fajla";
                }
            }else{
                echo "Ne mozete da aploudujete fajlove ovog tipa";
            }
        }
        
    }
    if(isset($_POST['obrisi'])){
        //pitaj jos jednom korisnika da li stvarno zeli
        $id = $_POST['recept_id'];
        $sql = "DELETE FROM recepti WHERE recept_id = '$id'";
        if (mysqli_query($konekcija, $sql)) {
            move_uploaded_file($fileTmpName,$fileDestination);
            header("Location: index.php");
        } else {
            echo "Neuspesno brisanje " . mysqli_error($konekcija);
        }
    }
}?>
