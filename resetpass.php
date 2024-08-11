<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     // Check if 'username' and 'email' are set in the POST data
    if (isset($_POST['username']) && isset($_POST['email'])) {

         // Echo the values of 'username' and 'email' for testing
        echo $_POST['username'];
        echo $_POST['email'];
    }

    
     // Check if the form with name 'submit' was submitted
    if (isset($_POST['submit'])) {
        include './pages/conixion.php';
        $username = $_POST['username'];
        $email = $_POST['email'];

         // Prepare SQL query to select user based on username and email
        $requete = "SELECT * FROM users WHERE username = :username AND Email = :email";
        $statment = $con->prepare($requete);
        $statment->bindParam(':username', $username);
        $statment->bindParam(':email', $email);
        $statment->execute();
        $result = $statment->fetch(PDO::FETCH_ASSOC);


        // Check if a matching user was found based on username and email
        if ($result && $username == $result['username'] && $email == $result['Email']) {
            //header("location:newpass.php");
            echo $result['username'];
            echo $result['Email'];
        }
    }
}
?>


<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="container d-flex justify-content-center align-items-center">
    <form method="POST">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Enter Username</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="username">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Enter Email</label>
            <input type="text" class="form-control" id="exampleInputPassword1" name="email">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Reset Password</button>
    </form>
</body>
</html>
