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

//Provjera jeli korisnik prijavljen
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

$opis = $cijena = $naslov= "";
$katmat = 0;
$katfiz = 0;
$katprog = 0;

//Ova ce se funkcija pokrenuti nakon submitanja
if($_SERVER["REQUEST_METHOD"] == "POST"){

 
    $naslov = trim($_POST["naslov"]);
    $opis = trim($_POST["opis"]);
    $cijena = trim($_POST["cijena"]);


    if (isset($_POST['matematika'])) {
        $katmat = true; 
    } else {
        $katmat = false;
    }
    if (isset($_POST['fizika'])) {
        $katfiz = true; 
    } else {
        $katfiz = false;
    }
    if (isset($_POST['prog'])) {
        $katprog = true; 
    } else {
        $katprog = false;
    }

        $sql = "UPDATE users SET naslovUsuge1 = ?, opisUsluge1 = ?, cijenaUsluge1 = ?, 
        katmat = ?, katfiz = ?, katprog = ? WHERE id = ?";

        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssssss", $param_naslov, $param_opis, $param_cijena, $param_katmat, 
            $param_katfiz, $param_katprog, $param_id);

            $param_naslov = $naslov;
            $param_opis = $opis;
            $param_cijena = $cijena;
            $param_katmat = $katmat;
            $param_katfiz = $katfiz;
            $param_katprog = $katprog;
            $param_id = $_SESSION["id"];
            

            if(mysqli_stmt_execute($stmt)){
                header("location: welcome.php");
                exit();
            } else{
                echo "Nešto je pošlo po krivu. Pokušajte kasnije!";
            }

            mysqli_stmt_close($stmt);
        }
    }
 
    mysqli_close($link);

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dodaj oglas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>

    $(document).ready(function(){
        var id = "<?php echo $rows['id']; ?>";

        $.ajax({
            url:"fetch.php",
            method:"POST",
            data: {id:id},
            dataType:"JSON",
            success:function(data)
            { 
             document.getElementById("naslov").value = data.naslovUsuge1;
             document.getElementById("cijena").value = data.cijenaUsluge1;
             $('#opis').text(data.opisUsluge1);

            } 
         });
    });
    </script>
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
        <h2>Dodaj / izmjeni oglas na <b>Instrukcije Portal</b></h2>
        <p>Popunite podatke kako bi objavili ili izmjenili oglas</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group">
                <label>Naslov usluge</label>
                <input id="naslov" type="text" name="naslov" class ="form-control" value="123">
            </div>
                
            <div class="form-group">
                <label>Opis usluge</label>
                <textarea name="opis" id="opis" class="form-control" value="">123</textarea>
                
            </div>
            <div class="form-group">
                <label>Područje usluge</label><br>
                <?php if ($rows['katmat'] == true) {
                    echo "<input type='checkbox' id='matematika' name='matematika' value='Matematika' checked>";
                } else {echo "<input type='checkbox' id='matematika' name='matematika' value='Matematika' >";} ?>
                <label for="matematika">Matematika</label><br>

                <?php if ($rows['katfiz'] == true) {
                    echo "<input type='checkbox' id='fizika' name='fizika' value='Fizika' checked>";
                } else {echo "<input type='checkbox' id='fizika' name='fizika' value='Fizika' >";} ?>
                <label for="fizika">Fizika</label><br>

                <?php if ($rows['katprog'] == true) {
                    echo "<input type='checkbox' id='prog' name='prog' value='prog' checked>";
                } else {echo "<input type='checkbox' id='prog' name='prog' value='prog' >";} ?>
                <label for="prog">Programiranje</label>

            </div>
            <div>
                <label>Cijena usluge (u kunama)</label>
                <input id="cijena" type="text" name="cijena" class ="form-control" value="123">
            </div>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
        <p><a href="welcome.php">Vrati se na Moj Profil</a></p>
    </div>    
</body>
</html>