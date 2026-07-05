

<?php
session_start();


if(!isset($_SESSION['user'])){
header("Location: login.php");
exit();
}
include "db.php";


$result = mysqli_query($conn,"SELECT * FROM vehicles");


$totalCars = mysqli_num_rows($result);
$occupied = $totalCars;
$available = 50 - $occupied;
?>


<!DOCTYPE html>
<html>
<head>


<title>Hypercar Parking HUD</title>


<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="stylesheet" href="style.css">


</head>


<body>


<div class="container">


<h1 class="title">⚡ HYPERCAR PARKING HUD</h1>


<div class="nav">
<a href="history.php">History</a>
<a href="revenue.php">Revenue</a>
<a href="logout.php">Logout</a>
</div>




<div class="cards">


<div class="card">
<h3>Total Cars</h3>
<p class="counter" data-target="<?php echo $totalCars ?>">0</p>
</div>


<div class="card">
<h3>Occupied Slots</h3>
<p class="counter" data-target="<?php echo $occupied ?>">0</p>
</div>


<div class="card">
<h3>Available Slots</h3>
<p class="counter" data-target="<?php echo $available ?>">0</p>
</div>


</div>




<h2 class="section">ACTIVE VEHICLES</h2>


<form action="insert.php" method="POST" class="form">


<input type="text" name="plate" placeholder="Plate Number" required>
<input type="text" name="owner" placeholder="Owner Name" required>
<input type="number" name="slot" placeholder="Slot" required>


<button type="submit" name="addVehicle" class="addbtn">ADD VEHICLE</button>


</form>




<input type="text" id="searchBar" placeholder="Search Plate or Owner">




<!-- RESPONSIVE TABLE WRAPPER -->
<div class="table-container">


<table id="vehicleTable">


<thead>
<tr>
<th>ID</th>
<th>Plate Number</th>
<th>Owner</th>
<th>Slot</th>
<th>Time Parked</th>
<th>Fee</th>
<th>Action</th>
</tr>
</thead>


<tbody>


<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr>


<td><?php echo $row['id']; ?></td>
<td><?php echo $row['plate_number']; ?></td>
<td><?php echo $row['owner_name']; ?></td>
<td><?php echo $row['slot_number']; ?></td>


<td class="timer" data-time="<?php echo $row['time_in']; ?>">0:00</td>
<td class="fee">0 ₱</td>


<td>

    <a class="editbtn" href="edit.php?id=<?php echo $row['id']; ?>">EDIT</a>

    <a class="exitbtn" href="exit.php?exit_id=<?php echo $row['id']; ?>">
        EXIT
    </a>

</td>


</tr>


<?php } ?>


</tbody>
</table>


</div>


</div>


<script>


// SEARCH FUNCTION
const searchBar = document.getElementById("searchBar");


searchBar.addEventListener("keyup", function () {


    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll("#vehicleTable tbody tr");


    rows.forEach(row => {


        const plate = row.children[1].textContent.toLowerCase();
        const owner = row.children[2].textContent.toLowerCase();


        if (plate.includes(value) || owner.includes(value)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }


    });


});

</script>


<script src="script.js"></script>


</body>
</html>



