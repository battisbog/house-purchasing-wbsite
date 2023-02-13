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
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

if (isset($_POST['add_house'])){

    mysql_query("start transaction;");

    $house_id = abs(crc32(uniqid()));
    $owner_id = abs(crc32(uniqid()));

    $sql1 = "INSERT INTO house_info (`house_id`,
    `price`,
    `bedrooms`,
    `bathrooms`,
    `sqft_living`,
    `floors`,
    `sqft_basement`,
    `street`,
    `city`,
    `zip`,
    `water_supply`,
    `heating_type`,
    `furnishing`,
    `garage`,
    `available`)
    VALUES
    (".$house_id.",
    ".$_POST['price'].",
    ".$_POST['bedrooms'].",
    ".$_POST['bathrooms'].",
    ".$_POST['sqft_living'].",
    ".$_POST['floors'].",
    ".$_POST['sqft_basement'].",
    '".$_POST['street']."',
    '".$_POST['city']."',
    '".$_POST['zip']."',
    '".$_POST['water_supply']."',
    '".$_POST['furnishing']."',
    '".$_POST['garage']."',
    'Y');";

    $sql2 = "INSERT INTO `ahp5143_431W`.`owners`
    (`owner_id`,
    `fname`,
    `lname`,
    `email`,
    `phone`)
    VALUES
    (".$owner_id.",
    '".$_POST['fname']."',
    '".$_POST['lname']."',
    '".$_POST['email']."',
    '".$_POST['phone'].";";

    $sql3 = "INSERT INTO `ahp5143_431W`.`owner_to_house`
    (`owner_id`,
    `house_id`)
    VALUES
    ($owner_id,
    $house_id);";

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec($sql1);
    $conn->exec($sql2);
    $conn->exec($sql3);

    echo "Listing Published successfully";

// PHP transaction
if( $sql1 && $sql2 && $sql3 )
{
//   mysql_query("commit;");
  $conn->exec("commit;");
}
else
{
  $conn->exec("rollback;");

}
}
?>

<script>
var timer = setTimeout(function() {
    window.location='index.php'
}, 2000);
</script>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles.css">
    </head>
  <body>
    <h1>Add your own Listing</h1>
    <form id="add_house" method="POST" >    
    <h3>Enter Your infromation</h3>

    <label for="fname">First Name:</label>
    <input type="text" id="fname" name="fname" required/>
    <br></br>
    
    <label for="lname">Last Name:</label>
    <input type="text" id="lname" name="lname" required/>
    <br></br>
    
    <label for="email">Email Address:</label>
    <input type="text" id="email" name="email" required/>
    <br></br>

    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" required/>

    <br></br>
    <h3>Enter house details</h3>

    <label for="City">City:</label>
    <input type="text" id="city" name="city" required/>
    <br></br>

    <label for="City">Zip:</label>
    <input type="text" id="zip" name="zip" required/>
    <br></br>

    <label for="Address">Address:</label>
    <input type="text" id="address" name="address" required/>
    <br></br>
    
    <label for="Floors">Floors:</label>
    <input type="text" id="floors" name="floors" required/>
    <br></br>

    <label for="Bedrooms">Bedrooms:</label>
    <input type="tel" id="bedrooms" name="bedrooms" required/>
    <br></br>

    <label for="Bathrooms">Bathrooms:</label>
    <input type="text" id="bathrooms" name="bathrooms" required/>
    <br></br>

    <label for="Square feet">Square feet:</label>
    <input type="text" id="sqft_living" name="sqft_living" required/>
    <br></br>

    <label for="sqft_basement">Basement Square feet:</label>
    <input type="text" id="sqft_basement" name="sqft_basement" required/>
    <br></br>

    <label for="water_supply">Water Supply:</label>
    <input type="text" id="water_supply" name="water_supply" required/>
    <br></br>

    <label for="heating_type">Heating Type:</label>
    <input type="text" id="heating_type" name="heating_type" required/>
    <br></br>

    <label for="Furnishing">Furnishing:</label>
    <input type="text" id="furnishing" name="furnishing" required/>
    <br></br>

    <label for="garage">Garage Spaces:</label>
    <input type="text" id="garage" name="garage" required/>
    <br></br>

    <label for="Listing Price">Listing Price:</label>
    <input type="text" id="price" name="price" required/>

    <br><br>    
    <input class="button" type="submit" name="add_house" id="search" value="Publish">       
    <br><br>    

    </form>
  </body>
</html>