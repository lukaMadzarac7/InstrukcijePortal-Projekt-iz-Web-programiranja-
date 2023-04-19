<?php
$id = $_POST["id"];
if($_POST["id"] == "katfiz"){
    $query = "SELECT * FROM users WHERE users.katfiz = true 
    ORDER BY RAND ( )  
    LIMIT 1";
}else if($_POST["id"] == "katmat"){
    $query = "SELECT * FROM users WHERE users.katmat = true 
    ORDER BY RAND ( )  
    LIMIT 1";
}else if($_POST["id"] == "katprog"){
    $query = "SELECT * FROM users WHERE users.katprog = true 
    ORDER BY RAND ( )  
    LIMIT 1";
}else if(is_numeric($id)){
    $query = "SELECT * FROM users WHERE users.id = '".$id."'
    ORDER BY RAND ( )  
    LIMIT 1";

}

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'demo');
 

$connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 $result = mysqli_query($connect, $query);
 while($row = mysqli_fetch_array($result))
 {
  $data["naslovUsuge1"] = $row["naslovUsuge1"];
  $data["opisUsluge1"] = $row["opisUsluge1"];
  $data["cijenaUsluge1"] = $row["cijenaUsluge1"];
  $data["username"] = $row["username"];
  $data["email"] = $row["email"];
  $data["katmat"] = $row["katmat"];
  $data["katfiz"] = $row["katfiz"];
  $data["katprog"] = $row["katprog"];

 }

 echo json_encode($data);

?>