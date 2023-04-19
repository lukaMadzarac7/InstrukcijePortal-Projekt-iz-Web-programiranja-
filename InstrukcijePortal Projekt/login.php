<?php

session_start();
 
//Provjera jeli korisnik vec ulogiran
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: http://localhost/LoginSystem/welcome.php");
    exit;
}
 

require_once "config.php";
 

$username = $password = "";
$username_err = $password_err = $login_err = "";
 
//Ova ce se funkcija pokrenuti nakon submitanja
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    //Provjera jeli ime prazno
    if(empty(trim($_POST["username"]))){
        $username_err = "Unesite korisničko ime.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    //Provjera jeli lozinka prazna
    if(empty(trim($_POST["password"]))){
        $password_err = "Unesite lozinku.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validacija podataka
    if(empty($username_err) && empty($password_err)){

        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = $username;
            

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                // Provjera jeli postoji to korisnicko ime u bazi
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            //Lozinka je tocna
                            session_start();
                            
                            // Pohrana podataka u _SESSION
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirekcija na home page
                            header("location: http://localhost/LoginSystem/main.php");
                        } else{
                            // Lozinka nije tocna
                            $login_err = "Krivo korisničko ime ili lozinka.";
                        }
                    }
                } else{
                    // Korisnicko ime ne postoji
                    $login_err = "Krivo korisničko ime ili lozinka.";
                }
            } else{
                echo "Nešto je pošlo po krivu. Pokušajte kasnije!";
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
    <title>Login</title>
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
        <h2>Logiraj se na <b>Instrukcije Portal</b></h2>
        <p>Unesite svoje korisničke podatke</p>
        <br>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Korisničko ime</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Lozinka</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Nemate korisnički račun? <a href="register.php">Registriraj se!</a></p>
            <p><a href="main.php">Vrati se na Home Page</a></p>
        </form>
    </div>
</body>
</html>