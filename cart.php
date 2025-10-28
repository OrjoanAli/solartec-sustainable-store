<?php
include_once("config.php");

// function call to remove and add the products into the cart
if (isset($_GET['prod_id'])) {
    // Check stock before adding to cart
    increase($_GET['prod_id']);
}

if (isset($_GET['remove_id'])) {
    removeFromCart($_GET['remove_id']);
}

if (isset($_GET['decrease_id'])) {
    decrease($_GET['decrease_id']);
}


function increase($id) {
    global $conn;
    $q = "SELECT prod_stock FROM product WHERE prod_id = $id";
    $result = mysqli_query($conn, $q);
    $row = mysqli_fetch_array($result);
    $stockCount = $row['prod_stock'];
    
    // Get current quantity in cart (or 0 if not in cart)
    //this line checks if the product is already in the cart
    $currentQty = isset($_SESSION['prod' . $id]) ? $_SESSION['prod' . $id] : 0;
    
    // Only add if we haven't reached stock limit
    if ($currentQty < $stockCount) {
        if (isset($_SESSION['prod' . $id])) {
            $_SESSION['prod' . $id]++; // already exists, add to it
        } else {
            $_SESSION['prod' . $id] = 1; // does not exist, make it the first
        }
    }
    header('Location: cart.php');
    exit;
}

function decrease($id) {
    if (isset($_SESSION['prod' . $id])) {
        $_SESSION['prod' . $id]--;
        if ($_SESSION['prod' . $id] <= 0) {
            unset($_SESSION['prod' . $id]);
        }
    }
    header('Location: cart.php');
    exit;
}

// This function should be removed or updated to use checkStockAndAdd
function addToCart($id) {
    increase($id);
}

function removeFromCart($id) {
    unset($_SESSION['prod' . $id]);
    header('Location: cart.php');
    exit;
}

$totalQuantity = 0; // Initialize total quantity variable

foreach ($_SESSION as $key => $value) {
    if (substr($key, 0, 4) == 'prod') { // Check if the session key refers to a product
        $prod_id = substr($key, 4); // Extract product ID
        $quantity = $_SESSION['prod' . $prod_id]; // Get the quantity from the session
        $totalQuantity += $quantity; // Add the quantity to the total
    }
}

include_once("header.php"); 

// Display stock warning message if it exists
if (isset($_SESSION['stock_message'])) {
    echo '<div class="alert alert-warning text-center">' . $_SESSION['stock_message'] . '</div>';
    // Clear the message after displaying it
    unset($_SESSION['stock_message']);
}

// Start the HTML content using heredoc stored in $item
$item = <<<DELIMETER
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="business" value="n5qb414706833@business.example.com">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="currency_code" value="USD">

    <div class="container py-5">
        <h2 class="text-center mb-5">Your Shopping Cart</h2>
        <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead class="table-primary">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
DELIMETER;

$total = 0;
$prod_Counter = 0;
foreach ($_SESSION as $key => $value) { // check all the info for what the customer added 
    if (substr($key, 0, 4) == 'prod') { // then display it in the table 
        $prod_Counter++;
        $prod_id = substr($key, 4);
        $result = mysqli_query($conn, "SELECT * FROM product WHERE prod_id = $prod_id");
        $product = mysqli_fetch_assoc($result);

        $name = $product['prod_name'];
        $price = $product['prod_price'];
        $stock = $product['prod_stock']; // Get available stock
        $quantity = $_SESSION['prod' . $prod_id];
        $total += $price * $quantity;

        // Show different button states based on stock availability
        $increaseButton = ($quantity < $stock) 
            ? "<a href='cart.php?prod_id=$prod_id' class='btn btn-sm btn-success'>+</a>"
            : "<button disabled class='btn btn-sm btn-secondary'>+</button>";

        // Append this product's row to $item
        $item .= <<<DELIMETER
<tr>
    <td>$name</td>
    <td>&#36;$price</td>
    <td>$quantity</td>
    <td>
    $increaseButton
    <a href="cart.php?remove_id=$prod_id" class="btn btn-sm btn-danger">Remove</a>
    <a href="cart.php?decrease_id=$prod_id" class="btn btn-sm btn-danger">-</a>
    </td>

    <input type="hidden" name="item_name_{$prod_Counter}" value="$name"> 
    <input type="hidden" name="item_number_{$prod_Counter}" value="{$prod_Counter}"> 
    <input type="hidden" name="amount_{$prod_Counter}" value="$price"> 
    <input type="hidden" name="quantity_{$prod_Counter}" value="$quantity"> 
</tr>
DELIMETER;
    }
}

// Add total row and PayPal button to the end of the HTML
$item .= <<<DELIMETER
<tr class='table-secondary fw-bold'>
    <td colspan='2'>Total</td>
    <td>$totalQuantity</td>
    <td colspan='2'>&#36;$total</td>
</tr>
</tbody>
</table>
<input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online">
</div>
</div>
</form>
DELIMETER;

// Output the entire block at once
echo $item;
?>

<?php include("2DownButton.php"); ?>
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>
<?php include("footer.php"); ?>