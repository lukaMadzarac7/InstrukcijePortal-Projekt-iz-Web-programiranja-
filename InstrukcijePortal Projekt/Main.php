<?php

session_start();

 
//Provjera jeli korisnik vec ulogiran, ako nije ide redirekcija na login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

/////////////////////////////HVATANJE PODATAKA////////////////////////////////////

$user = 'root';
$password = '';

$database = 'demo';


$servername='localhost';
$mysqli = new mysqli($servername, $user,
                $password, $database);
 
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}

$theID = $_SESSION["id"];
$all = "SELECT * FROM users WHERE users.id = $theID;";
$result = $mysqli->query($all);
$rows = $result->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en">

<head>
        <br>
        <h1 id ="MainTitle" > Instrukcije Portal </h1>
        <p id="Podnaslov" >Pozdrav, <U><?php echo $rows['username']; ?></u>!</p>

    <link rel="stylesheet" href="style.css">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="myScript.js"></script>
    

</head>
<body>

<div class ="container">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="main.php"> Početna</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="oportalu.php">O portalu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="kontakt.php">Kontakt</a>
              </li>    
              <li class="nav-item">
                <a class="nav-link" href="pomoc.php">Pomoć</a>
              </li>  
              <li class="nav-item">
                <a style ="color:blue;" class="nav-item nav-link" href="http://localhost/LoginSystem/login.php">Moj profil</a>
              </li>  
            </ul>
          </div>
        </div>
      </nav>
    </div>

    <div class = "container-fluid" id="background">
        <img src="bi2.jpg" class="BIstretch"/>
    </div>

    <div class="container" id="MainImage">
        <img src="new3.jpg" class="MIstretch rounded" />
        
    </div>


    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="d-grid gap-2">
                    <button id ="matGumb" name="matGumb" class="btn btn-primary" type="button" onclick="changeCategory(this.id)">Matematika</button>
                  </div>
            </div>

            <div class="col-4">
                <div class="d-grid gap-2">
                    <button id="fizGumb" name="fizGumb" class="btn btn-secondary" type="button" onClick="changeCategory(this.id)">Fizika</button>
                </div>
            </div>

            <div class="col-4">
                <div class="d-grid gap-2">
                    <button id="progGumb" name="progGumb" class="btn btn-secondary" type="button" onClick="changeCategory(this.id)">Programiranje</button>
                </div>
            </div>

    </div>
    <br>

<div class="containter">
    <div style="border:1px solid black;padding:10px;" id="oglas1">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <br>
                <h4><span id="naslov1"></span></h4>
                <h5> Opis:</h5>
                <p><span id="opis1"></p>
                <h5>Lokacija:</h5>
                <p> Osijek, Osječko-baranjska županija</p>
                <h5>Cijena:</h5>
                <p style="color:green;"><span id="cijena1"></span> kn</p> 
                
                <button type='button' name="b1" class="btn btn-outline-primary" onclick="toggleText(this.name)">Kontaktiraj!</button>
                <p id='demo1' style='display: none'><b>Ime instruktora:</b> <span id="imein1"></span><b><br>E-mail:</b> <span id="emailin1"></span></p>  
                <br>
                <br>
            </div>
            <div class="geeks col-lg-6 col-md-12 d-flex justify-content-center">
                <img id= "image1" name="image" class="imgMath" src="math2.jpg"  />  
            </div>
        </div>
    </div>

    <div class="" style="border:1px solid black; padding:10px;" id="oglas2">
        <div class="row">
            <div class="col-lg-6 col-md-12">
            <br>
                <h4><span id="naslov2"></span></h4>
                <h5> Opis:</h5>
                <p><span id="opis2"></p>
                <h5>Lokacija:</h5>
                <p> Osijek, Osječko-baranjska županija</p>
                <h5>Cijena:</h5>
                <p style="color:green;"><span id="cijena2"></span> kn</p> 
                
                <button type='button' name="b2" class="btn btn-outline-primary" onclick="toggleText(this.name)">Kontaktiraj!</button>
                <p id='demo2' style='display: none'><b>Ime instruktora:</b> <span id="imein2"></span><b><br>E-mail:</b> <span id="emailin2"></span></p>  
                <br>
                <br>
            </div>
            <div class="geeks col-lg-6 col-md-12  d-flex justify-content-center">
                <img id= "image2" class="imgMath" src="math2.jpg"  />
                
            </div>
        </div>
        
        
    </div>
    

    <div class="" style="border:1px solid black;padding:10px;" id="oglas3">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <br>
                <h4><span id="naslov3"></h4>
                <h5>Opis:</h5>
                <p><span id="opis3"></p>
                <h5>Lokacija:</h5>
                <p> Osijek, Osječko-baranjska županija</p>
                <h5>Cijena:</h5>
                <p style="color:green;"> <span id="cijena3"> kn</p> 
                <button type='button' name="b3" class="btn btn-outline-primary" onclick="toggleText(this.name)">Kontaktiraj!</button>
                <p id='demo3' style='display: none'><b>Ime instruktora:</b> <span id="imein3"></span><b><br>E-mail:</b> <span id="emailin3"></span></p>  
                <br>
                <br>
            </div>
            <div class="geeks col-lg-6 col-md-12  d-flex justify-content-center">
                <img id= "image3" class="imgMath" src="math2.jpg"  />
                
            </div>
        </div> 
    </div>
</div>
<br>

</body>
</html>
