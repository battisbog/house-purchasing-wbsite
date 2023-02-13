<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = 'abc123';
$password = 'YOUR PASSWORD HERE';
$host = 'localhost';
$dbname = 'YOUR DATABASE NAME HERE';



// $sql = "SELECT *
//         FROM house_info hi, owners o, owner_to_house oh, house_features_hf
//         WHERE hi.house_id = ".$_POST['house_id']."
//         AND hi.house_id = oh.house_id 
//         AND oh.owner_id = o.owner_id
//         OR hi.house_id = hf.house_id;";

$sql = "SELECT *
        FROM house_info hi, owners o, owner_to_house oh
        WHERE hi.house_id = ".$_POST['house_id']."
        AND hi.house_id = oh.house_id 
        AND oh.owner_id = o.owner_id;";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
$q = $pdo->query($sql);
$q->setFetchMode(PDO::FETCH_ASSOC);
$row = $q->fetch();
?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<title>House Details</title>
</head>
<body>

<h1>House Details</h1>
<link rel="stylesheet" href="styles.css">


<h3>House Information</h3>
<table id="details">
            <tr>
                <th>Price:</th>
                <td>$<?php echo htmlspecialchars($row['price']) ?><td>
            </tr>
            <tr>
                <th>City:</th>
                <td><?php echo htmlspecialchars($row['city']) ?></td>
            </tr>
            <tr>
                <th>Street:</th>
                <td><?php echo htmlspecialchars($row['street']) ?></td>
            </tr>
            <tr>
                <th>Zip:</th>
                <td><?php echo htmlspecialchars($row['zip']) ?></td>
            </tr>
            <tr>
                <th>Square Feet:</th>
                <td><?php echo htmlspecialchars($row['sqft_living']) ?></td>
            </tr>           
            <tr>
                <th>Bedrooms:</th>
                <td><?php echo htmlspecialchars($row['bedrooms']) ?></td>
            </tr>            
            <tr>
                <th>Bathrooms:</th>
                <td><?php echo htmlspecialchars($row['bathrooms']) ?></td>
            </tr>
            <tr>
                <th>Water supply:</th>
                <td><?php echo htmlspecialchars($row['water_supply']) ?></td>
            </tr>
            <tr>
                <th>Heating type:</th>
                <td><?php echo htmlspecialchars($row['heating_type']) ?></td>
            </tr>
            <tr>
                <th>Furnishing:</th>
                <td><?php echo htmlspecialchars($row['furnishing']) ?></td>
            </tr>
            <tr>
                <th>Garage:</th>
                <td><?php echo htmlspecialchars($row['garage']) ?></td>
            </tr>
        </table>

    <h3>Extra Features</h3>
    <table id="extra_features">
    <?php
    $sql2 = "SELECT * FROM house_features WHERE house_id = ".$_POST['house_id'].";";
    $q2 = $pdo->query($sql2);
    $q2->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <tr>
        <th>Features:</th>
        <?php while ($row2 = $q2->fetch()): ?>
        <td><?php echo htmlspecialchars($row2['feature']); ?></td>
        <?php endwhile; ?>
    </tr>
  </table>

  <h3>History</h3>
    <table id="history">
    <?php
    $sql3 = "SELECT * FROM history h, house_to_history hh
             WHERE hh.house_id = ".$_POST['house_id'].";";
    $q3 = $pdo->query($sql3);
    $q3->setFetchMode(PDO::FETCH_ASSOC);
    ?>
  <tr>
    <th>Date</th>
    <th>Event</th>
    <th>Price</th>
  </tr>
  <tr>
    <?php while ($row3 = $q3->fetch()): ?>
    <td><?php echo htmlspecialchars($row3['date']); ?></td>
    <td><?php echo htmlspecialchars($row3['event']); ?></td>
    <td><?php echo "$".htmlspecialchars($row3['price']); ?></td>
    <?php endwhile; ?>

  </tr>

  </table>


    <h3>Owner Details</h3>
    <table id="owner_info">
    <tr>
        <th>Name:</th>
        <td><?php echo htmlspecialchars($row['fname']) ?>  <?php echo htmlspecialchars($row['lname']) ?></td>
    </tr>
    <tr>
        <th>Email:</th>
        <td><?php echo htmlspecialchars($row['email']) ?></td>
    </tr>
    <tr>
        <th>Phone:</th>
        <td><?php echo htmlspecialchars($row['phone']) ?></td>
    </tr>
    </table>

    <br> </br>

    <table id="change">
    <tr>
        <th>Is the house is unavailable?</th>
        <td><?php echo '<form id="update" action="/update.php" method="POST"><input type="submit" name="update" value="Update Listing"><input type="hidden" name="house_id" value="' . $row['house_id'] . '"></form>'; ?></td>
    </tr>
    <tr>
        <th>Want to remove your Listing?</th>
        <td><?php echo '<form id="delete" action="/delete.php" method="POST"><input type="submit" name="delete" value="delete"><input type="hidden" name="house_id" value="' . $row['house_id'] . '"></form>'; ?></td>
    </tr>

    </table>





</body>
</html>
