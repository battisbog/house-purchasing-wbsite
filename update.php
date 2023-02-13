<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = 'abc123';
$password = 'YOUR PASSWORD HERE';
$host = 'localhost';
$dbname = 'YOUR DATABASE NAME HERE';


$sql = "UPDATE house_info 
        SET available = 'N'
        WHERE house_id = ".$_POST['house_id'].";";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->exec($sql);

echo "Listing seuccessfully updated!";

?>

<script>
var timer = setTimeout(function() {
    window.location='index.php'
}, 3000);
</script>
