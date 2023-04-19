
<?php

session_start();
 
// Provjera jeli korisnik ulogiran
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//////////////HVATANJE PODATAKA/////////////////////////
$user = 'root';
$password = '';
$database = 'pametniportal';


$servername='localhost';
$mysqli = new mysqli($servername, $user,
                $password, $database);
 
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}

$theID = $_SESSION["id"];
$all = "SELECT * FROM user WHERE user.UserID = $theID;";
$result = $mysqli->query($all);
$mysqli->close();
$rows = $result->fetch_assoc();

//////////////////////////////////////////////


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Moj profil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>

    $(document).ready(function(){
        var id = "<?php echo $rows['UserID']; ?>";

        $.ajax({
            url:"fetch.php",
            method:"POST",
            data: {id:id},
            dataType:"JSON",
            success:function(data)
            { 
             $('#naslov').text(data.naslovUsuge1);
             $('#opis').text(data.opisUsluge1);
             $('#cijena').text(data.cijenaUsluge1);

            } 
         });
    });



    </script>
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class = "container-fluid" id="background" style="width: 100%; height: 100%; position: fixed; left: 0px; top: 0px; z-index: -1;">
        <img src="bi2.jpg" class="BIstretch" style="width:100%;height:100%;"/>
    </div>
    <h1 style="font-weight: bold;"class="my-5">Moj profil <br> ____________________</b> </h1>


    <h5 class="my-5">Korisničko Ime Računa- <b><?php echo $rows['PortalUserName']; ?></b> </h5>
    <h5 class="my-5">Email Adresa Računa- <b><?php echo $rows['UserEmail']; ?></b> </h5>
 
    <p>
        <a href="logout.php" class="btn btn-secondary ml-3">Odjavi se</a> 
        <a href="reset-password.php" class="btn btn-warning">Promjeni lozinku</a>
        <p><a href="main.php">Vrati se na Home Page</a></p>
        <h2 style="font-weight: bold;"class="my-5"> Moj oglas</b> </h2>
        <a href="dodajoglas.php" button type="button" class="btn btn-success">Izmjeni/Dodaj</button>
        <a href="izbrisiOglas.php" class="btn btn-danger ml-3">Izbriši oglas</a> 
    
        <h2 style="font-weight: bold;"class="my-5"> _________________________________________________</b> </h2>
        
    </p>
    <?php 
    /*
        if ($rows['naslovUsuge1'] != NULL){

            echo '<div class="container" style="border:1px solid black;">';
            echo '<h4 class="my-5"><b>Naslov Oglasa</b> : ';
            echo '<span id="naslov"></span>';
            echo'</h4>';
            echo '<h5 class="my-5"><b>Opis Oglasa</b> : ';
            echo '<span id="opis"></span>';
            echo'</h5>';
            echo '<h5 class="my-5"><b>Cijena Oglasa</b> : ';
            echo '<span id="cijena"></span>';
            echo' kn/h </h5>';

        echo '</div>' ;
            echo '</div>';
        }else{
            echo '<h5 class="my-5"><b>Nemate objavljen oglas!</b>';

        }

        */

    ?>
    
    <br>
    <br>
    <br>

</body>
</html>