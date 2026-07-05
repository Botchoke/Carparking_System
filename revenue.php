

<?php
session_start();


if(!isset($_SESSION['user'])){
header("Location: login.php");
exit();
}


include "db.php";


$month = isset($_GET['month']) ? intval($_GET['month']) : date("n");
$year = date("Y");


/* Monthly totals */
$totalQuery = mysqli_query($conn,"
SELECT
SUM(total_fee) as revenue,
COUNT(*) as cars
FROM history
WHERE MONTH(time_out)='$month' AND YEAR(time_out)='$year'
");


$totalData = mysqli_fetch_assoc($totalQuery);


$totalRevenue = $totalData['revenue'] ?? 0;
$totalCars = $totalData['cars'] ?? 0;

/* Total Sales This Year */
$yearQuery = mysqli_query($conn,"
SELECT SUM(total_fee) AS totalYearSales
FROM history
WHERE YEAR(time_out)='$year'
");

$yearData = mysqli_fetch_assoc($yearQuery);

$totalYearSales = $yearData['totalYearSales'] ?? 0;


/* Chart Data */




/* Chart Data */
$chart = mysqli_query($conn,"
SELECT
DAY(time_out) as day,
SUM(total_fee) as revenue,
COUNT(*) as cars
FROM history
WHERE MONTH(time_out)='$month' AND YEAR(time_out)='$year'
GROUP BY DAY(time_out)
");


$days=[];
$revenues=[];
$cars=[];


for($i=1;$i<=31;$i++){
$days[$i]=$i;
$revenues[$i]=0;
$cars[$i]=0;
}


while($row=mysqli_fetch_assoc($chart)){
$d=$row['day'];
$revenues[$d]=$row['revenue'];
$cars[$d]=$row['cars'];
}


$days=array_values($days);
$revenues=array_values($revenues);
$cars=array_values($cars);


$monthName = date("F", mktime(0,0,0,$month,1));
?>


<!DOCTYPE html>
<html>


<head>


<title>Parking Revenue</title>


<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link rel="stylesheet" href="style.css">


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




</head>


<body>


<div class="container">


<h1 class="title">💰 Revenue Analytics (<?php echo $monthName; ?>)</h1>


<div class="nav">
<a href="index.php">Dashboard</a>
<a href="history.php">History</a>
<a href="logout.php">Logout</a>
</div>




<div class="cards">

    <div class="card">
        <h3>💰 Total Earnings</h3>
        <p>₱<?php echo number_format($totalRevenue); ?></p>
    </div>

    <div class="card">
        <h3>🚗 Total Cars Parked</h3>
        <p><?php echo $totalCars; ?></p>
    </div>

    <div class="card">
        <h3>📈 Total Sales This Year</h3>
        <p>₱<?php echo number_format($totalYearSales,2); ?></p>
    </div>

</div>




<div class="chartBox">
<canvas id="revenueChart"></canvas>
</div>




<div class="months">


<a href="revenue.php?month=1">Jan</a>
<a href="revenue.php?month=2">Feb</a>
<a href="revenue.php?month=3">Mar</a>
<a href="revenue.php?month=4">Apr</a>
<a href="revenue.php?month=5">May</a>
<a href="revenue.php?month=6">Jun</a>
<a href="revenue.php?month=7">Jul</a>
<a href="revenue.php?month=8">Aug</a>
<a href="revenue.php?month=9">Sep</a>
<a href="revenue.php?month=10">Oct</a>
<a href="revenue.php?month=11">Nov</a>
<a href="revenue.php?month=12">Dec</a>


</div>


</div>




<script>


const carsData = <?php echo json_encode($cars); ?>;
const month = <?php echo $month; ?>;


const ctx = document.getElementById('revenueChart');


new Chart(ctx,{
type:'line',
data:{
labels: <?php echo json_encode($days); ?>,
datasets:[{
label:'Revenue (PHP)',
data: <?php echo json_encode($revenues); ?>,
borderColor:'#00f7ff',
backgroundColor:'rgba(0,247,255,0.2)',
borderWidth:4,
tension:0.4,
fill:true,
pointRadius:6,
pointHoverRadius:8,
pointBackgroundColor:'#00f7ff'
}]
},
options:{
interaction:{
mode:'index',
intersect:false
},
plugins:{
legend:{
labels:{
color:'#9cfaff',
font:{size:14}
}
},
tooltip:{
backgroundColor:'#000',
borderColor:'#00f7ff',
borderWidth:1,
callbacks:{
afterLabel:function(context){
return "Cars Parked: "+carsData[context.dataIndex];
}
}
}
},
scales:{
x:{
ticks:{
color:'#9cfaff'
},
grid:{
color:'rgba(0,247,255,0.15)'
}
},
y:{
ticks:{
color:'#9cfaff'
},
grid:{
color:'rgba(0,247,255,0.15)'
}
}
}
}
});


</script>


</body>
</html>





