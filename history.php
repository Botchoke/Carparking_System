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

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

if($search) {
    $result = mysqli_query($conn, "
        SELECT * FROM history 
        WHERE plate_number LIKE '%$search%' 
        OR slot_number LIKE '%$search%'
        ORDER BY id DESC
    ");
} else {
    $result = mysqli_query($conn,"SELECT * FROM history ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Parking History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>

<div class="history-container">
    <div class="history-top">
        <div class="history-brand">
            <h1>PARKING <span>HISTORY</span></h1>
            <span class="sub">RECORDS</span>
        </div>
        <div class="history-nav">
            <a href="index.php"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="revenue.php"><i class="fas fa-chart-line"></i> Revenue</a>
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div class="history-search">
        <form method="GET" action="history.php">
            <i class="fas fa-search"></i>
            <input type="text" name="search" placeholder="Search by plate or slot..." value="<?php echo htmlspecialchars($search); ?>" />
            <button type="submit"><i class="fas fa-search"></i> Search</button>
            <?php if($search): ?>
                <a href="history.php" class="clear-btn"><i class="fas fa-times"></i> Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- TABLE -->
    <div class="history-table-wrapper">
        <table class="history-table">
            <thead>
                <tr>
                    <th>PLATE NO.</th>
                    <th>SLOT</th>
                    <th>DATE</th>
                    <th>TIME IN</th>
                    <th>TIME OUT</th>
                    <th>AMOUNT</th>
                    <th>PAYMENT</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): 
                        $time_in = strtotime($row['time_in']);
                        $time_out = strtotime($row['time_out']);
                        
                        $status = 'Paid';
                        $statusClass = 'status-paid';
                        
                        // Get payment method from database
                        $payment = isset($row['payment_method']) ? $row['payment_method'] : 'Cash';
                        $paymentClasses = [
                            'Cash' => 'payment-cash',
                            'GCash' => 'payment-gcash',
                            'Maya' => 'payment-maya',
                            'Credit Card' => 'payment-card',
                            'Credit' => 'payment-card'
                        ];
                        $paymentClass = $paymentClasses[$payment] ?? 'payment-cash';
                    ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['plate_number']); ?></strong></td>
                            <td><span class="slot-badge"><?php echo $row['slot_number']; ?></span></td>
                            <td><?php echo date('Y-m-d', $time_in); ?></td>
                            <td><?php echo date('H:i', $time_in); ?></td>
                            <td><?php echo date('H:i', $time_out); ?></td>
                            <td class="amount">₱<?php echo number_format($row['total_fee'], 2); ?></td>
                            <td><span class="payment-badge <?php echo $paymentClass; ?>"><?php echo htmlspecialchars($payment); ?></span></td>
                            <td><span class="status-badge <?php echo $statusClass; ?>"><?php echo $status; ?></span></td>
                            <td>
                                <button class="receipt-btn" onclick="showReceipt(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars($row['plate_number']); ?>', '<?php echo $row['slot_number']; ?>', '<?php echo $row['time_in']; ?>', '<?php echo $row['time_out']; ?>', '<?php echo $row['total_fee']; ?>', '<?php echo htmlspecialchars($payment); ?>')">
                                    <i class="fas fa-receipt"></i> View receipt
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="no-data">No history records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ===== RECEIPT MODAL ===== -->
<div class="receipt-modal" id="receiptModal">
    <div class="receipt-overlay" onclick="closeReceipt()"></div>
    <div class="receipt-content">
        <button class="receipt-close" onclick="closeReceipt()"><i class="fas fa-times"></i></button>
        <div class="receipt" id="receiptContent">
            <!-- Receipt content loaded by JavaScript -->
        </div>
    </div>
</div>

<!-- ===== DELETE CONFIRM MODAL ===== -->
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
// ============================================
// DELETE FUNCTIONALITY
// ============================================
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

// ============================================
// RECEIPT FUNCTIONALITY
// ============================================
function showReceipt(id, plate, slot, time_in, time_out, total_fee, payment) {
    const dateIn = new Date(time_in);
    const dateOut = new Date(time_out);
    
    // Use the payment method from database
    const paymentMethod = payment || 'Cash';

    const receiptHTML = `
        <div class="receipt">
            <div class="receipt-header">
                <h1>PARKREV</h1>
                <div class="sub">Parking Management System</div>
                <div class="phone">Tel: (02) 8888-0000</div>
            </div>
            <div class="receipt-body">
                <div class="receipt-row">
                    <span class="label">Receipt No:</span>
                    <span class="value">RCP-${String(id).padStart(3, '0')}</span>
                </div>
                <div class="receipt-row">
                    <span class="label">Date:</span>
                    <span class="value">${dateIn.toISOString().split('T')[0]}</span>
                </div>
                <div style="margin: 12px 0; border-bottom: 1px dashed rgba(79,124,172,0.2);"></div>
                <div class="receipt-row" style="font-weight: 600; color: #9cfaff;">
                    <span>SESSION DETAILS</span>
                </div>
                <div class="receipt-row">
                    <span class="label">Plate No.</span>
                    <span class="value">${plate}</span>
                </div>
                <div class="receipt-row">
                    <span class="label">Slot</span>
                    <span class="value">${slot}</span>
                </div>
                <div class="receipt-row">
                    <span class="label">Time In</span>
                    <span class="value">${dateIn.toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'})}</span>
                </div>
                <div class="receipt-row">
                    <span class="label">Time Out</span>
                    <span class="value">${dateOut.toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'})}</span>
                </div>
                <div style="margin: 12px 0; border-bottom: 1px dashed rgba(79,124,172,0.2);"></div>
                <div class="receipt-row" style="font-weight: 600; color: #9cfaff;">
                    <span>PAYMENT</span>
                </div>
                <div class="receipt-row">
                    <span class="label">Method</span>
                    <span class="value">${paymentMethod}</span>
                </div>
                <div class="receipt-row">
                    <span class="label">Status</span>
                    <span class="value" style="color: #2ed573;">Paid</span>
                </div>
                <div class="receipt-row total">
                    <span class="label">TOTAL</span>
                    <span class="value">₱${parseFloat(total_fee).toFixed(2)}</span>
                </div>
            </div>
            <div class="receipt-footer">
                <div class="thankyou">Thank you for parking with us!</div>
                <div>Please drive safely.</div>
                <div class="ref">SESSION-${String(id).padStart(3, '0')}</div>
            </div>
        </div>
    `;

    document.getElementById('receiptContent').innerHTML = receiptHTML;
    document.getElementById('receiptModal').classList.add('active');
}

function closeReceipt() {
    document.getElementById('receiptModal').classList.remove('active');
}

// Close receipt with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeReceipt();
    }
});

// Close receipt when clicking outside content
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.querySelector('.receipt-overlay');
    if (overlay) {
        overlay.addEventListener('click', closeReceipt);
    }
});

console.log('📋 History page loaded');
console.log('🧾 Receipt viewer ready');
</script>

</body>
</html>
