<?php
include_once("config.php");
include_once("header.php");
// Initialize total price and quantity
$total = 0;
$totalQuantity = 0;
$status = ''; // Prevent undefined variable warning

if(isset($_GET['st'])){
    if($_GET['st'] == "Completed"){
        $status = "Completed";
        $currency = $_GET['cc'];
        $amount = $_GET['amt'];
        $trans = $_GET['tx'];
        $fname = $_GET['first_name'];
        $lname = $_GET['last_name'];
        $q = "INSERT INTO payments (first_name, last_name, amt, st, tx, cc)
              VALUES ('$fname', '$lname', '$amount', '$status', '$trans', '$currency')";
        
        $result = query($q);
        
        // Calculate total quantity ONCE, outside of transaction handling
        foreach ($_SESSION as $key => $value) {
            if (substr($key, 0, 4) == 'prod') { // Check if the session key refers to a product
                $prod_id = substr($key, 4); // Extract product ID
                $quantity = $_SESSION['prod' . $prod_id]; // Get the quantity from the session
                $totalQuantity += $quantity; // Add the quantity to the total
            }
        }
        
        if (mysqli_affected_rows($conn) > 0){
            echo "Transaction saved successfully";
        
            // Insert each item into transaction_items table
            foreach ($_SESSION as $key => $value) {
                if (substr($key, 0, 4) == 'prod') {
                    $prod_id = substr($key, 4);
                    $quantity = $_SESSION['prod' . $prod_id];
        
                    $insertItem = "INSERT INTO transaction_items (transaction_id, product_id, quantity)
                                   VALUES ('$trans', '$prod_id', '$quantity')";
                    mysqli_query($conn, $insertItem);
                }
            }
        } else {
            echo "<font style='color:red'> Transaction failed to save </font>";
        }
        
    }
}

// Debug or show PayPal return data
echo <<<DELIMETER
<div class="container py-5">
    <h2 class="text-center mb-3">Thank You for Your Purchase!</h2>
    <div class="text-center mb-4">
DELIMETER;
if ($status === "Completed") {
    echo <<<DELIMETER
        <p><strong>Transaction ID:</strong> $trans</p>
        <p><strong>Status:</strong> $status</p>
        <p><strong>Amount Paid:</strong> $$amount $currency</p>
DELIMETER;
} else {
    echo "<p class='text-danger'>Payment not completed or invalid return data.</p>";
}
echo <<<DELIMETER
    </div>
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-success">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>
            </thead>
        <tbody>
DELIMETER;

// Reset total for recalculation
$total = 0;
// Don't reset totalQuantity here - we already calculated it once

// Loop through session products
foreach ($_SESSION as $key => $value) {
    if (substr($key, 0, 4) == 'prod') {
        $prod_id = substr($key, 4);
        $result = mysqli_query($conn, "SELECT * FROM product WHERE prod_id = $prod_id");
        $product = mysqli_fetch_assoc($result);
        $name = $product['prod_name'];
        $price = $product['prod_price'];
        $quantity = $_SESSION['prod' . $prod_id];
        $total += $price * $quantity;
        // Don't add to totalQuantity again here
        
        echo <<<DELIMETER
<tr>
    <td>$name</td>
    <td>&#36;$price</td>
    <td>$quantity</td>
</tr>
DELIMETER;
    }
}

// Show total
echo <<<DELIMETER
<tr class="table-secondary fw-bold">
    <td>Total</td>
    <td>&#36;$total</td>
    <td>$totalQuantity</td>
</tr>
</tbody>
</table>
<p class="text-center mt-4">We hope to see you again soon!</p>
<a href="index.php?paid=1" class="btn btn-primary mt-4">Return to Home</a>
<a href="index.php" class="btn btn-primary mt-4">Print Bill</a>
</div>
</div>
DELIMETER;

// to insert in the transactions table 
if(isset($_GET['amt'])){
    $currency = $_GET['cc'];
    $amount = $_GET['amt'];
    $trans = $_GET['tx'];
    $status = $_GET['st'];
    $datetime = date('Y-m-d H:i:s');
    $q = "INSERT INTO transactions (amount, currency, transactionsID , status , dateTime )  
          VALUES ('$amount', '$currency', '$trans', '$status' , '$datetime')";
    
    $result = query($q);
    if (mysqli_affected_rows($conn) > 0){
        echo "Transaction saved successfully";
    } else {
        echo "<font style='color:red'> Transaction failed to save </font>";
    }
}

include("2DownButton.php");
include("footer.php");
?>