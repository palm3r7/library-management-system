<?php include 'connection.php'?>
<?php include 'header.php'?>
<?php include 'sidebar.php'?>

<?php

//error checking
error_reporting(E_ALL);
ini_set('display_errors', 1);

//variables
$name = $email = "";
$nameErr = $emailErr = "";

//form validation
function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//form required
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    //check if name is entered
    if(empty($_POST['name'])){
        $nameErr = 'PLEASE ENTER NAME';
    } else{
        $name = test_input($name);
    }

    //check if email is entered
    if(empty($_POST['email'])){
        $emailErr = 'PLEASE ENTER EMAIL';
    } else{
        $email = test_input($email);
        
        if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailErr = 'INVALID EMAIL FORMAT!';
     }
    }

    //if no errors submit form
    if($_SERVER["REQUEST_METHOD"] == 'POST'  && empty($nameErr) && empty($emailErr)){

    //mysql query
    //query to prevent sql injection
    $stmt = $conn->prepare("INSERT INTO borrowers(name, email) VALUES(?, ?)");
    $stmt->bind_param("ss", $name, $email,);

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
    <title>STUDENT MANAGEMENT SYSTEM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="textbox">
        <?php if(!empty($message)){ ?>
        <p class="success"><?php echo $message; ?></p>
        <?php } ?>
        <form action="add borrower.php" method="post" class="textbox-form">
            <label for="name">Name:</label>
            <input type="text" placeholder="Enter name" name="name" value="<?php echo $name;?>"><br><br>
            <?php echo $nameErr;?><br><br>

            <label for="email">Email:</label>
            <input type="email" placeholder="Enter email" name="email" value="<?php echo $email;?>"><br><br>
            <?php echo $emailErr;?><br><br>

            <button type="submit">SUBMIT</button>
        </form>
    </div>   
</body>
</html>