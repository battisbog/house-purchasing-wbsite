<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = 'abc123';
$password = 'YOUR PASSWORD HERE';
$host = 'localhost';
$dbname = 'YOUR DATABASE NAME HERE';



$sql = "DELETE FROM house_info WHERE house_id = ".$_POST['house_id'].";";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

?>

<!DOCTYPE html>
<html>
    <body>
    <form id="del" method="POST" name="del">    
    <label for="house_id_to_del">Confirm House ID:</label>
    <input type="text" name="house_id_to_del" />
    <input type="button" name="del" value="confirm"/>
    </form>
    </body>
</html>