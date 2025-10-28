<?php require_once ("config.php");
if (isset($_GET['paid'])) {
    foreach ($_SESSION as $key => $value) {
        $prodID = substr($key, 4);
        $q = "SELECT prod_stock FROM product WHERE prod_id = $prodID";
        $result = query($q);
        $row = mysqli_fetch_array($result);
        $stock = $row['prod_stock'];
        $newStock = $stock - $value;

        $q = "UPDATE product SET prod_stock = $newStock WHERE prod_id = $prodID";
        $result = query($q);
    }
    session_destroy();
}



?>

<!DOCTYPE html>
<html lang="en">
    

<head>
    <meta charset="utf-8">
    <title>Solartec - Renewable Energy Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css?v=1.0" rel="stylesheet">
</head>

<body>

<?php include "spinnerstart.php";?>

    
<?php 
include("header.php"); 
?>
<?php 
connection();
//query($str); whyyyyyyyyyyy
?>
<?php include "carousel.php" ?>

<a name="about"></a>
  <!-- About Start -->
  <?php include "about.php";?>
  <!-- About End -->

  <a name="service"></a>
  <!-- Service Start -->
  <?php //include "service.php";?>
  <!-- Service End -->


  <!-- Feature Start -->
  <a name="feature1"></a>
<?php include "feature1.php"?>
  <!-- Feature End -->



  <a name="project"></a>
  <!-- Projects Start -->
  <?php include "project.php";?>

  <!-- Quote Start 
  <a name="quote"></a>-->
  <?php //include "quote.php";?>
  <!-- Quote End -->

  <a name="team"></a>
  <!-- Team Start -->
  <?php include "team.php";?>
  <!-- Team End -->


  <!-- Testimonial Start -->
  <?php //include "testimonial.php";?>
  <!-- Testimonial End -->


  <!-- Footer Start -->
  <?php include "footer.php";?>
  <!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>

<!-- Floating Cart Button -->
<a href="cart.php" class="btn btn-lg btn-primary btn-lg-square rounded-circle cart-btn" id="cartBtn">
        <i class="bi bi-cart"></i> <!-- Cart Icon -->
    </a>

</a>



    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>