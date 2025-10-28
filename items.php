<?php 
include_once("config.php"); 
include_once("header.php");
if (isset($_GET['prod_id'])) {
    $_SESSION['prod' . $_GET['prod_id']] += 1;
}

?>
<!DOCTYPE html>
<html lang="en">

<!--why we call once config.php??
That can lead to duplicate database connections,
which can slow down the website or break things.-->
<body>

<div class="container-xxl py-5">
    <div class="container">
        <?php
        $prod_id = $_GET['prod_id'];
        $result = query("SELECT * FROM product WHERE prod_id = $prod_id");
        $product = mysqli_fetch_array($result);
        ?>
            <div class="row align-items-center g-5">
                <div class="col-md-6 text-center">
                    <img class="img-fluid rounded" style="border-radius: 10px; max-height: 400px;"
                        src="<?= $product['prod_img'] ?>" alt="Product Image">
                </div>
                <div class="col-md-6">
                    <h1 class="display-5 mb-3"><?= $product['prod_name'] ?></h1>
                    <p class="lead mb-3"><?= $product['prod_desc_short'] ?></p>
                    <p><?= $product['prod_desc'] ?></p>
                    <p class="h4 mb-2"><strong>Price:</strong> $<?= $product['prod_price'] ?></p>
                    <div class="d-flex align-items-center gap-5 flex-wrap">
                        <p class="mb-0"><strong>Rating:</strong> <?= str_repeat("⭐", $product['prod_rating']) ?></p>
                        <button class="btn btn-primary rounded-pill py-2 px-4" onclick="addToCart(<?= $product['prod_id'] ?>)">Add to Cart</button>
                    </div>
                </div>
            </div>
    </div>
</div>
<?php include("testimonial.php"); ?>
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>
<?php include("2DownButton.php"); ?>
<?php include("footer.php"); ?>
</body>
</html>
