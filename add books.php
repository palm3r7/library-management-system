<?php include 'connection.php'?>
<?php include 'header.php'?>
<?php include 'sidebar.php'?>

<?php

//error checking
error_reporting(E_ALL);
ini_set('display_errors', 1);

//variables
$author = $title = $quantity = "";
$authorErr = $titleErr = $quantityErr = "";

//form validation function
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//form required
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $author = $_POST['author'] ?? '';
    $title = $_POST['title'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    //check if author is entered
    if(empty($_POST['author'])){
        $authorErr = 'PLEASE ENTER AUTHOR';
    } else{
        $author = test_input($author);
    }

    //check if title has been entered
    if(empty($_POST['title'])){
        $titleErr = 'PLEASE ENTER TITLE';
    } else{
        $title = test_input($title);
    }

    //check if quantity has been entered
    if(empty($_POST['quantity'])){
        $quantityErr = 'PLEASE ENTER QUANTITY';
    } else{
        $quantity = test_input($quantity);
    }

    //if no error submit form
    if($_SERVER["REQUEST_METHOD"] == 'POST'  && empty($authorErr) && empty($titleErr) && empty($quantityErr)){
        
     //mysql query
     //query to prevent sql injection
     $stmt = $conn->prepare("INSERT INTO books(author, title, quantity) VALUES(?, ?, ?)");
     $stmt->bind_param("sss", $author, $title, $quantity);

     //execute and check result
     if($stmt->execute()){
        $message = "Added successfully!";
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
    <title>LIBRARYS MANAGEMENT SYSTEM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="textbox2">
        <?php if(!empty($message)){ ?>
        <p class="success"><?php echo $message; ?></p>
        <?php } ?>
        <form action="add books.php" method="post" class="textbox2-form">
            <label for="author">AUTHOR:</label>
            <input type="text" placeholder="Enter author" name="author" value="<?php echo $author;?>"><br><br>
            <?php echo $authorErr;?><br><br>

            <label for="title">TITLE:</label>
            <input type="text" placeholder="Enter title" name="title" value="<?php echo $title;?>"><br><br>
            <?php echo $titleErr;?><br><br>

            <label for="quantity">QUANTITY:</label>
            <input type="text" placeholder="Enter quantity" name="quantity" value="<?php echo $quantity;?>"><br><br>
            <?php echo $quantityErr;?><br><br>

            <button type="submit">SUBMIT</button>
        </form>
    </div>
</body>
</html>