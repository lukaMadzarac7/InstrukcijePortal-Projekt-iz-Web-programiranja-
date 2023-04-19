<?php
session_start();


/////////////////////////////UHVATI PODATKE////////////////////////////////////

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
$mysqli->close();
$rows = $result->fetch_assoc();

/////////////////////////////////////////////////////////////////

 
//Provjera jeli korisnik ulogiran
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 

require_once "config.php";
 

    $opis = $cijena = $naslov= "";

    $naslov = "";
    $opis = "";
    $cijena = 0;


        $sql = "UPDATE users SET naslovUsuge1 = ?, opisUsluge1 = ?, cijenaUsluge1 = ? WHERE id = ?";

        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "ssss", $param_naslov, $param_opis, $param_cijena, $param_id);

            $param_naslov = $naslov;
            $param_opis = $opis;
            $param_cijena = $cijena;
            $param_id = $_SESSION["id"];
            

            if(mysqli_stmt_execute($stmt)){
                header("location: login.php");
                exit();
            } else{
                echo "Nešto je pošlo po krivu. Pokušajte kasnije!";
            }

            mysqli_stmt_close($stmt);
        }
    
    
    mysqli_close($link);


?>
 
