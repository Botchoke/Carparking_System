<?php
session_start();


if(!isset($_SESSION['user'])){
header("Location: login.php");
exit();
}


include "db.php";


/* DELETE HISTORY */


if(isset($_GET['delete'])){
$id = intval($_GET['delete']);
mysqli_query($conn,"DELETE FROM history WHERE id='$id'");
header("Location: history.php");
exit();
}


/* EDIT HISTORY */


if(isset($_POST['update'])){
$id = intval($_POST['id']);
$fee = floatval($_POST['fee']);


mysqli_query($conn,"UPDATE history SET total_fee='$fee' WHERE id='$id'");
header("Location: history.php");
exit();
}


$result = mysqli_query($conn,"SELECT * FROM history ORDER BY id DESC");
?>


<!DOCTYPE html>
<html>


<head>
    <title>Parking History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>

<body>


<div class="container">


<h1 class="title">📜 PARKING HISTORY</h1>


<div class="nav">
<a href="index.php">Dashboard</a>
<a href="revenue.php">Revenue</a>
<a href="logout.php">Logout</a>
</div>


<table>


<thead>


<tr>
<th>ID</th>
<th>Plate Number</th>
<th>Owner</th>
<th>Slot</th>
<th>Time In</th>
<th>Time Out</th>
<th>Total Fee</th>
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
<td><?php echo $row['time_in']; ?></td>
<td><?php echo $row['time_out']; ?></td>


<td>
<form method="POST" style="display:flex; gap:5px; justify-content:center;">
<input type="hidden" name="id" value="<?php echo $row['id']; ?>">
<input type="number" name="fee" value="<?php echo $row['total_fee']; ?>" style="width:80px;">
<button type="submit" name="update" class="editbtn">EDIT</button>
</form>
</td>


<td>
<a class="exitbtn deleteBtn" data-id="<?php echo $row['id']; ?>" href="#">DELETE</a>
</td>


</tr>


<?php } ?>


</tbody>


</table>


</div>




<!-- DELETE CONFIRM MODAL -->


<div id="deleteModal" class="modal">


<div class="modal-box">


<p>Delete this record?</p>


<label style="font-size:14px;">
<input type="checkbox" id="dontAsk">
Do not ask again
</label>


<div class="modal-buttons">
<button id="confirmDelete">Delete</button>
<button id="cancelDelete">Cancel</button>
</div>


</div>


</div>




<script>


let deleteId = null;


document.querySelectorAll(".deleteBtn").forEach(btn => {


btn.addEventListener("click", function(){


deleteId = this.dataset.id;


if(localStorage.getItem("skipDeleteConfirm") === "true"){
window.location = "history.php?delete=" + deleteId;
return;
}


document.getElementById("deleteModal").style.display="flex";


});


});


document.getElementById("confirmDelete").onclick = function(){


if(document.getElementById("dontAsk").checked){
localStorage.setItem("skipDeleteConfirm","true");
}


window.location = "history.php?delete=" + deleteId;


};


document.getElementById("cancelDelete").onclick = function(){
document.getElementById("deleteModal").style.display="none";
};


</script>


</body>
</html>

