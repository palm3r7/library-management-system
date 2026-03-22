<?php include 'connection.php'?>
<?php include 'header.php'?>
<?php include 'sidebar.php'?>

<?php
$query = "SELECT
            books.title AS title,
            borrowers.name AS name,
            borrow.borrow_date,
            borrow.status,
            borrow.ID AS borrow_ID
            FROM borrow
            JOIN books ON borrow.book_id = books.ID
            JOIN borrowers ON borrow.borrower_id = borrowers.ID";

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
    <title>STUDENT MANAGEMENT SYSTEM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="table3-container">
        <table class="viewborrowedbooks-table">
            <tr>
                <th>Book</th>
                <th>Borrower</th>
                <th>Borrow date</th>
                <th>Status</th>
            </tr>
            <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                    <td><?php echo $row['title'];?></php></td>
                    <td><?php echo $row['name'];?></php></td>
                    <td><?php echo $row['borrow_date'];?></php></td>
                    <td><?php echo $row['status'];?></php></td>
                    </tr>
                    <?php
                }
            }else{
                echo "</tr><td colspan='4'>No records found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>