<?php include 'connection.php'?>
<?php include 'header.php'?>
<?php include 'sidebar.php'?>

<?php

//error checking
error_reporting(E_ALL);
ini_set('display_errors', 1);

//variables
$borrower = $book = $date = $status = "";
$borrowerErr = $dateErr = $bookErr = $statusErr = "";

//form validation
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
//form required
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $borrower = $_POST['borrower_id'] ?? '';
    $book = $_POST['book_id'] ?? '';
    $date = $_POST['date'] ?? '';
    $status = $_POST['status'] ?? '';

    //check if borrower is entered
    if(empty($_POST['borrower_id'])){
        $borrowerErr = 'PLEASE ENTER NAME';
    } else{
        $borrower = test_input($borrower);
    }

    //check if book is entered
    if(empty($_POST['book_id'])){
        $bookErr = 'PLEASE ENTER BOOK';
    } else{
        $book = test_input($book);
    }

    //check if status has been entered
    if(empty($_POST['status'])){
        $statusErr = 'PLEASE ENTER status';
    } else{
        $status = test_input($status);
    }

    //check if date is entered
    if(empty($_POST['date'])){
        $dateErr = 'PLEASE ENTER DATE';
    }

    //if no errors submit form
    if($_SERVER["REQUEST_METHOD"] == 'POST'  && empty($borrowerErr) && empty($bookErr) &&empty($dateErr) &&empty($statusErr)){

        //mysql query
        //query to prevent sql injection
        $stmt = $conn->prepare("INSERT INTO borrow(borrower_id, book_id, borrow_date, status) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("iiss", $borrower, $book, $date, $status);

        //execute and check result
        if($stmt->execute()){
          $message = "borrowed successfully!";
        } else{
            $message = "Error: " . $stmt->error;
        }
    }
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
    <div class="textbox3">
        <?php if(!empty($message)){ ?>
        <p class="success"><?php echo $message; ?></p>
        <?php } ?>
        <form action="borrow book.php" method="post" class="textbox3-form">
            <label for="borrower">Borrower:</label>
            <?php
            $sql = "SELECT ID, name FROM borrowers";
            $result = mysqli_query($conn, $sql);  
            ?>
            <select name="borrower_id" required>
                <option value="">Select borrower</option>
                <?php while ($row = mysqli_fetch_assoc($result)){?>
                <option value="<?php echo $row['ID']; ?>">
                    <?php echo $row['name']; ?>
                </option>
                <?php }?>
            </select><br><br><br>
            <?php echo $borrowerErr;?><br><br>

            <label for="book">book:</label>
            <?php
            $sql = "SELECT ID, title FROM books";
            $result = mysqli_query($conn, $sql);  
            ?>
            <select name="book_id" required>
                <option value="">Select book</option>
                <?php while ($row = mysqli_fetch_assoc($result)){?>
                <option value="<?php echo $row['ID']; ?>">
                    <?php echo $row['title']; ?>
                </option>
                <?php }?>
            </select><br><br><br>
            <?php echo $bookErr;?><br><br>

            <label for="status">Status:</label>
            <input type="text" placeholder="Enter status" name="status"><br><br>
            <?php echo $statusErr;?><br><br>

            
            <label for="date">Date:</label>
            <input type="date" id="borrowDate" name="date">
            
            <script>
                //sets the date automatically
                document.getElementById(
                    'borrowDate'
                ).valueAsDate = new Date();
            </script><br><br><br>

            <button type="submit">SUBMIT</button>
        </form>
    </div>
</body>
</html>