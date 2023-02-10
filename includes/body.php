<?php
  include 'dbh.php';

  class Recept{
    private $id;
    private $naslov;
    private $tekst;
    private $slika;


    public function __construct($id,$naslov, $tekst, $slika){
      $this->id = $id;
      $this->naslov = $naslov;
      $this->tekst = $tekst;
      $this->slika = $slika;
    }
    function getId(){
      return $this->id;
    }
    function getSlika(){
      return $this->slika;
    }
    function getNaslov(){
      return $this->naslov;
    }
    function getTekst(){
      return $this->tekst;
    }
    function setId(){
      $this->id = $id;
    }
    function setSlika($slika){
      $this->slika = $slika;
    }
    function setNaslov($naslov){
      $this->naslov = $naslov;
    }
    function setTekst($tekst){
      $this->tekst = $tekst;
    }
  }

  //  ADMIN FORMA
  if(isset($_SESSION['korisnik_id'])){
    
    if($_SESSION['korisnicko_ime'] == 'admin'){
      $id=$naziv = $opis = "";
      if(isset($_POST['izmeni'])){
        $id = $_POST['recept_id'];
        $naziv = $_POST['naziv'] ;
        $opis = $_POST['opis'];
      }?>
         
    <div id="admin" class="row justify-content-center mx-0">
        <form id="adminForm" method = "post" enctype="multipart/form-data" action="./index.php?stranica=adminFormHandling" >
            <div class="row s justify-content-center">
            <input type="hidden" name="recept_id" value="<?php echo $id?>">  
                <div class="col-3">
                    <label for="naziv" >Naziv: </label>
                </div>
                <div class="col-8">
                <input type="text" id="naziv" name="naziv" placeholder="Naziv recepta.." value = "<?php echo $naziv ?>"></br>
                </div>      
            </div>
            <div class="row s justify-content-center">
                <div class="col-3">
                    <label for="opis" >Opis: </label>
                </div>
                <div class="col-8">
                <textarea type="text" id="opis" name="opis" placeholder="Opis recepta.." ><?php echo $opis ?></textarea></br>
                </div>      
            </div>
            <div class="row s justify-content-center">
                <div class="col-3">
                    <label for="opis" >Slika: </label>
                </div>
                <div class="col-8">
                <input type="file" name="slika"></br>
                </div>      
            </div>
            <div class="row s justify-content-center pt-2">
                <div id="btnParent" class="col-4">
                    <button type="submit" class="btn" name="promeni">Promeni</button>
                </div>
            </div>
        </form>
        </div>
  <?php } }
    
    //KRAJ ADMIN FORME

  
  //Uzimamo informacije iz baze, da bi smo napravili objekte Recept
  function sqlVrednostJedneKolone($kolona,$tabela){
    global $konekcija;
    $array =  array();
    $sql = "SELECT $kolona from $tabela;";
    
    $result = mysqli_query($konekcija,$sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck != 0){
      while($row = mysqli_fetch_assoc($result)){
          array_push($array,$row[$kolona]);
      }
      return $array;
    }
  }

  $recept_id = sqlVrednostJedneKolone('recept_id','recepti');
  $naslovi = sqlVrednostJedneKolone('naziv','recepti');
  $tekstovi = sqlVrednostJedneKolone('opis','recepti');
  $slike = sqlVrednostJedneKolone('slika','recepti');

  
  
  //Dodajemo objekte Recept u listu $recepti
  function dodajRecepte(&$recepti,&$recept_id,&$naslovi,&$tekstovi,&$slike){
    $brojRecepata = sizeof($naslovi);
    for($i = 0; $i< $brojRecepata ;$i++){
      array_push($recepti,new Recept($recept_id[$i],$naslovi[$i],$tekstovi[$i],$slike[$i]));
    }
  }
 
  $recepti = array();
  dodajRecepte($recepti,$recept_id,$naslovi,$tekstovi,$slike);
  
  //Promesaj listu recepata
  shuffle($recepti);


  function ispisiRecepte($brojRecepata,$recepti){global $izmeni;global $obrisi?>
  
    <section class="container-fluid px-0 ">
    <div class="row align-items-center mx-0">
      <div name="relativan" class="col-md-6 order-2 order-md-1  ">
        <h3 class="opisStranice">Opis stranice klikni ovde <!--<a href="isplanirajObrok.html">Isplaniraj obrok</a><--></h3>
      </div>
      <div  class="col-md-6 order-1 order-md-2 px-0 mx-0">
        <img src="<?php echo  DIR_IMG . 'hranaa.jpg' ?>" class="img-fluid">
      </div>
    </div>
</section>
<?php
  for($i = 0; $i<$brojRecepata; $i++){?>
  <form method="post" >
  <section class="container px-0">
   <div class="container">
    <div class="row align-items-center text-center">
      <div class="col-md-6 <?php echo $i%2 ? ' order-1 order-md-1' : ' order-1 order-md-2'  ?> px-0"> <!--SLIKA-->
        <img src="<?php echo $recepti[$i]->getSlika();?>" class="img-fluid">
        <input type="hidden" name="slika" value="<?php echo $recepti[$i]->getSlika();?>">    <!--Nevidljivo input polje za cuvanje podataka o receptu -->
      </div>
      <div class = "col-md-6 <?php echo $i%2 ? 'order-2 order-md-2' : 'order-2 order-md-1'  ?>"> <!--TEKST-->

        <h4><?php echo $recepti[$i]->getNaslov();?></h4>
        <input type="hidden" name="naziv" value="<?php echo $recepti[$i]->getNaslov();?>">    <!--Nevidljivo input polje za cuvanje podataka o receptu -->
        <p ><?php echo $recepti[$i]->getTekst();?></p>
        <input type="hidden" name="opis" value="<?php echo $recepti[$i]->getTekst();?>">    <!--Nevidljivo input polje za cuvanje podataka o receptu -->

        <input type="hidden" name="recept_id" value="<?php echo $recepti[$i]->getId();?>">
        <?php
          if(isset($_SESSION['korisnik_id'])){
    
            if($_SESSION['korisnicko_ime'] == 'admin'){
        echo "<button type='submit' name='izmeni'>Izmeni</button><span>-</span><button type='submit' name='obrisi'>Obrisi</button>" ; }} ?>
        
      </div>
    </div>
   </div>
  </section>
  </form>
  <?php }} ?>

  
  


<?php ispisiRecepte(4,$recepti); ?>
