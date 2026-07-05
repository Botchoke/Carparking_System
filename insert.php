<?php


include "db.php";


if($_SERVER["REQUEST_METHOD"] == "POST"){


$plate = $_POST['plate'];
$owner = $_POST['owner'];
$slot = $_POST['slot'];


$sql = "INSERT INTO vehicles (plate_number, owner_name, slot_number)
VALUES ('$plate', '$owner', '$slot')";


if(mysqli_query($conn,$sql)){
header("Location: index.php");
exit();
}else{
echo "Error: " . mysqli_error($conn);
}


}


?>

