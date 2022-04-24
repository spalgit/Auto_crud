<?php
require_once "pdo.php";

if (isset($_POST['logout'])){
  header('Location: index.php');
  return;
}

$status = false;
$status_color = 'red';

if(isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])){
  if(strlen($_POST['make'])<1){
    $status = "Make is required";
  }elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
    $status = "Mileage and year must be numeric";
  }else{
    $make = htmlentities($_POST['make']);
    $year = htmlentities($_POST['year']);
    $mileage = htmlentities($_POST['mileage']);

    $stmt = $pdo->prepare(
      "INSERT INTO autos (make, year, mileage) VALUES (:make, :year, :mileage)"
    );
    $stmt->execute([
      ':make' => $make,
      ':year' => $year,
      ':mileage' => $mileage
    ]);
    $status = 'Record inserted';
    $status_color = 'green';
  }
}
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchall(PDO::FETCH_ASSOC);

 ?>

<html>
<head>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Tracking Autos for <?php echo htmlentities($_REQUEST['name']); ?></h1>

<?php

   echo "<p>";
   echo htmlentities($status);
   echo "</p>\n";
 ?>

<form method="POST">
<p>Make:
  <input type="text" name = "make" size="40"></p>
<p>Year:
  <input type="text" name = "year" size="40"></p>
<p>Mileage:
  <input type="text" name = "mileage" size="40"></p>
  <input type="submit" value="Add">
  <input type="submit" name = "logout", value="Logout">
</form>

<head></head><body><table border="1">
<?php
   foreach ($rows as $row) {
     // echo '<u1 class="qandaul"><li>';
     echo "<tr><td>";
     echo($row['year']);
     echo("</td><td>");
     echo($row['make']);
     echo("</td><td>");
     echo($row['mileage']);
     echo("</td></tr>\n");
     //
     //
     //
     // echo '<u1><li>';
     // echo($row['year']);
     // echo($row['make']);
     // echo($row['mileage']);
     // echo '</li><ul>';

     // echo("</td></tr>\n");
   }
 ?>
 </table>
</div>
</body>
