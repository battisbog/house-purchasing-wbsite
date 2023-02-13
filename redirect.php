<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = 'abc123';
$password = 'YOUR PASSWORD HERE';
$host = 'localhost';
$dbname = 'YOUR DATABASE NAME HERE';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $uname = $_POST['uname'];
    $pass = $_POST['pass'];
    $sql = 'SELECT uname, pass FROM users';
    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
    $user_type = '';
    while ($row = $q->fetch()):
        if ($row['user_type'] === 'customer'){
            $user_type = 'customer';
        }elseif ($row['user_type'] === 'owner'){
            $user_type = 'owner';
        }

        endwhile;

    

} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>


<!DOCTYPE html>    

<html>
    <head>
        <?php if($user_type === 'customer'): ?>
                <script>
                var timer = setTimeout(function() {
                    window.location='user_page.php'
                }, 3000);
            </script>
        <?php elseif($user_type === 'owner'): ?>
            <script>
            var timer = setTimeout(function() {
                    window.location='owner_page.php'
                }, 3000);
            </script>
        <?php endif; ?>


</head>

</html>