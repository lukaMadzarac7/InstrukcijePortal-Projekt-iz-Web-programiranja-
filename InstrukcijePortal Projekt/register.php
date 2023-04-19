<?php

require_once "config.php";
 
$email = $username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Ova se funkcija izvodi nakon submitanja
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    //  Validacija imena
    if(empty(trim($_POST["username"]))){
        $username_err = "Unesite korisničko ime.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Ime može sadržavati samo slova, brojke i donje crte.";
    } else{

        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);
            

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Ovo korisničko ime je već zauzeto.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Nešto je pošlo po krivu. Pokušajte kasnije!";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    // Validacija lozinke
    if(empty(trim($_POST["password"]))){
        $password_err = "Unesite lozinku.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Lozinka mora imati bar 6 simbola.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validacije conform passworda
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Potvrdite lozinku.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Lozinke nisu jednake.";
        }
    }

    $email = trim($_POST["email"]);
    
    // Pregled problema prije unosenja u bazu
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        

        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
            
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Enkripcija lozinke
            
            if(mysqli_stmt_execute($stmt)){

                header("location: login.php");
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
    <title>Sign Up</title>
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
        <h3>Registriraj se na <b>Instrukcije Portal</b></h3>
        <p>Popunite podatke kako bi napravili korisnički račun</p>
        <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Korisničko ime</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div> 
            <div class="form-group">
                <label>Email adresa</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>      
            <div class="form-group">
                <label>Lozinka</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Potvrdi lozinku</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">

            </div>
            <p>Već imate korisnički račun? <a href="login.php">Logiraj se!</a>.</p>
            <p><a href="main.php">Vrati se na Home Page</a></p>
        </form>
    </div>    
</body>
</html>