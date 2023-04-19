<?php

session_start();
 
// Provjera jeli korisnik ulogiran
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
require_once "config.php";
 

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Ova funkcija se izvodi nakon submitanja
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validacija nove lozinke
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Unesite novu lozinku.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Lozinka mora imati bar 6 simbola.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validacija conform passworda
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Potvrdite lozinku.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Lozinke nisu jednake.";
        }
    }
        
    // Pregled problema prije unosa u bazu
    if(empty($new_password_err) && empty($confirm_password_err)){

        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            if(mysqli_stmt_execute($stmt)){
                // Lozinka je uspjesno promjenjana
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Nešto je pošlo po krivu. Pokušajte kasnije.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    

    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Promjeni lozinku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class = "container-fluid" id="background" style="width: 100%; height: 100%; position: fixed; left: 0px; top: 0px; z-index: -1;">
        <img src="bi2.jpg" class="BIstretch" style="width:100%;height:100%;"/>
    </div>
    <div class="wrapper" style="  margin: auto; width: 50%; border: 3px ; padding: 100px;">
        <h2>Promjeni lozinku</h2>
        <p>Popunite podatke kako bi promjenili lozinku</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>Nova lozinka</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Potvrdi lozinku</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
        <p><a href="welcome.php">Vrati se na Moj Profil</a></p>
    </div>    
</body>
</html>