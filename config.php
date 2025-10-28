<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
defined("LOCALHOST") or define("LOCALHOST", "localhost");
defined("USERNAME") or define("USERNAME", "root");
defined("PASSWORD") or define("PASSWORD", "");
defined("DBNAME") or define("DBNAME", "solartecdatabase");

$conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD, DBNAME) or die("Connection to DB failed: " . mysqli_connect_error());

function connection(){
    global $conn;
    return $conn;
}

function query($str){
    global $conn;
    $result = mysqli_query($conn, $str);
    if (!$result) {
        die("SQL Error: " . mysqli_error($conn));
    }
    return $result;
}

//Gets all products from the product table that belong to a given category ID.
function getProductByCat($catid){
    global $conn;
    return query("SELECT * FROM product WHERE cat_id = $catid and  prod_stock > 0");

}

function getProduct(){
    global $conn;
    return query("SELECT * FROM product where prod_stock > 0 ");

}

function getProductByID($item){
    global $conn;
    return query("SELECT * FROM product WHERE product_id = $item and prod_stock > 0");
}

function check ($results){
    global $conn;
    if (!$results)
    echo mysqli_error($conn);
    }

    function register(){
        if (isset($_POST['submit'])){
            $user = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Check if user already exists
            $check = query("SELECT * FROM register WHERE email = '{$email}'");
            if(mysqli_num_rows($check) > 0){
                $_SESSION['error'] = "User already exists! you can login easily";
                return;
            }
    
            // Insert new user
            $insert = query("INSERT INTO register(fullname, email, password) 
                             VALUES ('{$user}', '{$email}', '{$password}')");
    
            if ($insert) {//This checks if the INSERT query was successful
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['error'] = "Registration failed!";
            }
        }
    }
    
    function login(){
        if (isset($_POST['submit'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $check = query("SELECT * FROM register WHERE email = '{$email}' AND password = '{$password}'");
    
            if(mysqli_num_rows($check) == 1){
                // Login success
                $_SESSION['user'] = mysqli_fetch_assoc($check); // Optional: store user info
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['error'] = "Incorrect email or password!";
            }
        }
    }


    function getAllTransactions($conn) {
        $query = "SELECT * FROM transactions ORDER BY dateTime DESC";
        $results = mysqli_query($conn, $query);
    
        if (!$results || mysqli_num_rows($results) == 0) {
            echo "<tr><td colspan='6'>No transactions found.</td></tr>";
            return;
        }
    
        while ($row = mysqli_fetch_assoc($results)) {
            $transactionID = $row['transactionsID'];
    
            // Fetch items from transaction_items for this transaction
            $itemQuery = "
                SELECT product.prod_name, transaction_items.quantity 
                FROM transaction_items 
                JOIN product ON product.prod_id = transaction_items.product_id 
                WHERE transaction_items.transaction_id = '$transactionID'
            ";
            $itemResult = mysqli_query($conn, $itemQuery);
    
            $itemString = "";
            while ($item = mysqli_fetch_assoc($itemResult)) {
                $itemString .= htmlspecialchars($item['prod_name']) . " (" . (int)$item['quantity'] . ")<br/>";
            }
    
            echo "<tr>
                    <td>" . htmlspecialchars($transactionID) . "</td>
                    <td>" . htmlspecialchars($row['amount']) . "</td>
                    <td>" . htmlspecialchars($row['currency']) . "</td>
                    <td>" . htmlspecialchars($row['status']) . "</td>
                    <td>" . htmlspecialchars($row['dateTime']) . "</td>
                    <td>$itemString</td>
                  </tr>";
        }
    }

    function getAllProducts($conn, $catid = null) {
        if ($catid) {
            $query = "SELECT * FROM product WHERE cat_id = " . intval($catid);
        } else {
            $query = "SELECT * FROM product";
        }
        
        $results = mysqli_query($conn, $query);
        
        if (!$results || mysqli_num_rows($results) == 0) {
            echo "<tr><td colspan='7' class='text-center text-danger'>No products found.</td></tr>";
            return;
        }
        
        while ($row = mysqli_fetch_assoc($results)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['prod_id']) . "</td>
                    <td>" . htmlspecialchars($row['prod_name']) . "</td>
                    <td>$" . htmlspecialchars($row['prod_price']) . "</td>
                    <td>" . htmlspecialchars($row['prod_desc_short']) . "</td>
                    <td>" . htmlspecialchars($row['prod_desc']) . "</td>
                    <td>" . htmlspecialchars($row['prod_rating']) . " ⭐</td>
                    <td>" . htmlspecialchars($row['prod_stock']) . "</td>
                  </tr>";
        }
    }

    /*function addCategory(){
        if (isset($_POST['cat_name'])) {  // Changed from 'submit' to 'cat_name'
            $cat_name = $_POST['cat_name'];
            $insert = query("INSERT INTO categories (cat_name) VALUES ('{$cat_name}')");  // Added missing )
            
            if ($insert) {
                echo "<script>alert('Category added successfully!');</script>";  // Fixed header
            } else {
                echo "<script>alert('Failed to add category!');</script>";
            }
        }
    }*/

    function addCategory(){
        if (isset($_POST['cat_name']) && !empty($_POST['cat_name'])) {
            $cat_name = trim($_POST['cat_name']);
            
            // Check if category already exists
            $check = query("SELECT * FROM categories WHERE cat_name = '{$cat_name}'");
            if (mysqli_num_rows($check) > 0) {
                echo "<script>alert('Category already exists!');</script>";
                return;
            }
            
            $insert = query("INSERT INTO categories (cat_name) VALUES ('{$cat_name}')");
            
            if ($insert) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    }
?>