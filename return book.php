<?php include 'connection.php'?>
<?php include 'header.php'?>
<?php include 'sidebar.php'?>

<?php
$query = "SELECT
            borrowers.name AS name,
            books.title AS title,
            borrow.ID AS borrow_ID,
            borrow.return_date
            FROM borrow
            JOIN borrowers ON borrow.borrower_id = borrowers.ID
            JOIN books ON borrow.book_id = books.ID";

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
    <div class="table-container">
        <table class="returnbook-table">
            <tr>
                <th>Name</th>
                <th>Book</th>
                <th>Return Date</th>
            </tr>
            <?php
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['title'];?></td>
                        <td>
                            <?php 
                             if($row['return_date']){
                               echo $row['return_date'];
                                } else {
                                  echo "Not returned";
                                }
                            ?>
                        </td>

                        <td>
                            <a href="returnBook.php?id=<?php echo $row['borrow_ID'];?>">Return</a>  |
                            <a href="deleteBorrow.php?id=<?php echo $row['borrow_ID'];?>">Delete</a>
                        </td>
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