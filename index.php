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
?>

<!DOCTYPE html>    
<html>    
<head>    
    <title>Home Page</title>    
</head>    
<body>    



<h1>Search Home</h1><br>    
<link rel="stylesheet" href="styles.css">

    <form id="search" method="POST" >    

    <div class="input-group">

        <tr>
        <td>City:</td>
        <td><input type="text" name="city" /></td>
    </tr>
    <tr>
        <td>Floors:</td>
        <td><input type="text" name="floors" /></td>
    </tr>
    <tr>
        <td>Bedrooms:</td>
        <td><input type="text" name="Bedrooms" /></td>
    </tr>
        <input type="checkbox" id="check" name="available">    
        <span>Show Available houses only</span>    

        <br></br>
        <input type="checkbox" id="check" name="sort_by_price">    
        <span>Sort by Price</span>    

        <br><br>    
        <input class="button" type="submit" name="search" id="search" value="Search houses">       
        <br><br>    

        </div>
    </form>    

    <div style="display: flex; justify-content: flex-end">
    <h3>List your own house</h3>
    <?php echo '<form id="insert" action="/insert.php" method="POST"><input type="submit" name="insert" value="Create Listing"></form>'; ?>
    </div>

    <h3>Search Results</h3><br>    
            <table border=1 cellspacing=2 cellpadding=2>
                <thead>
                <link rel="stylesheet" href="styles.css">
                    <tr>
                        <th>City</th>
                        <th>Address</th>
                        <th>Floors</th>
                        <th>Bedrooms</th>
                        <th>Bathrooms</th>
                        <th>Square feet</th>
                        <th>Price</th>
                        <th>Availibility</th>
                        <th>More info</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_POST['search'])){
                        // $sql = "SELECT * FROM house_info WHERE city = "."'".$_POST['city']."' ".
                        //         "AND bedrooms > "."'".$_POST['bedrooms']."'".
                        //         "AND sqft_living > "."'".$_POST['sqft_living']."';";
                        // $sql = "SELECT * FROM houses WHERE city = '$_POST['city']' AND bedrooms = $_POST['bedrooms'] AND sq = '$_POST['city']';";

                        $fields = array('city', 'Bedrooms', 'floors');
                        $conditions = array();
                        
                        foreach($fields as $field){
                            // if the field is set and not empty
                            if(isset($_POST[$field]) && $_POST[$field] != '') {
                                $conditions[] = "$field LIKE '" . $_POST[$field] . "'";
                            }
                        }

                            if (isset($_POST['available'])){
                                $conditions[] = "available = 'Y'";
                            }



                        // builds the query
                        $sql = "SELECT * FROM house_info ";
                        // if there are conditions defined
                        if(count($conditions) > 0) {
                            // append the conditions
                            $sql .= "WHERE " . implode (' AND ', $conditions); // you can change to 'OR', but I suggest to apply the filters cumulative
                        }

                        if (isset($_POST['sort_by_price'])){
                            $sql .= "ORDER BY price";
                        }

                                                
                        $q = $pdo->query($sql);
                        $q->setFetchMode(PDO::FETCH_ASSOC);
                            while ($row = $q->fetch()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['city']) ?></td>
                                <td><?php echo htmlspecialchars($row['street']); ?></td>
                                <td><?php echo htmlspecialchars($row['floors']); ?></td>
                                <td><?php echo htmlspecialchars($row['bedrooms']); ?></td>
                                <td><?php echo htmlspecialchars($row['bathrooms']); ?></td>
                                <td><?php echo htmlspecialchars($row['sqft_living']); ?></td>
                                <td><?php echo "$".htmlspecialchars($row['price']); ?></td>
                                <td><?php echo htmlspecialchars($row['available']); ?></td>
                                <td><?php echo '<form id="house_details" action="/details.php" method="post"><input type="submit" name="house_details" value="Details"><input type="hidden" name="house_id" value="' . $row['house_id'] . '"></form>'; ?></td>
                            </tr>
                        <?php endwhile; }?>    
                        
                </tbody>
            </table>


</body>
</head>
<html>