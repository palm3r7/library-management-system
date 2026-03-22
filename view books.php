<?php include 'connection.php'?>
<?php include 'header.php'?>
<?php include 'sidebar.php'?>

<?php
$query = "SELECT *
            FROM BOOKS";

$result = mysqli_query($conn, $query);
if(!$result){
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBRARY MANAGEMENT SYSTEM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="table2-container">
        <table class="viewbooks-table">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Quantity</th>
            </tr>
            <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><?php echo $row['title'];?></td>
                        <td><?php echo $row['author'];?></td>
                        <td><?php echo $row['quantity'];?></td>
                    </tr>
                    <?php   
                }    
            }else{
                echo "</tr><td colspan='3'>No records found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>