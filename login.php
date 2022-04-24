<?php
  if( isset($_POST['cancel'])){

    header("Location: index.php");
    return;
  }

  $salt = 'XyZzy12*_';
  $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
  $failure = false;
  $at = '@';

  if (isset($_POST['who']) && isset($_POST['pass'])){
     if (strlen($_POST['who'])< 1 || strlen($_POST['pass']) < 1){
       $failure = "Email and Password are required";
     }else{
       $pass = htmlentities($_POST['pass']);
       $email = htmlentities($_POST['who']);

       if((strpos($email, '@') === false)){
         $failure = "Email must have and @ sign";
       }else{
         $check = hash('md5', $salt.$pass);
         if($check == $stored_hash){
           error_log("Login Success". $email);
           header("Location: autos.php?name=".urlencode($email));
           return;
         }else{
           error_log("Login fail".$pass." $check");
           $failure = "Incorrect password";
         }
       }
     }
  }

  echo('<p style="color: red;">'.$failure."</p>\n");

 ?>


<html>
<head>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Please Login</h1>
<form method="POST">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/>
<label for="id_1723">Password</label>
<input type="text" name="pass" id="id_1723"><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>
