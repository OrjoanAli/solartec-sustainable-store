<?php
include("config.php");
$catid = @$_GET['catid']; // suppress warning if 'catid' is not set
$res = getProductByCat($catid);
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once("header.php"); ?>
<body>

<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="text-primary">Our Services</h6>
            <h1 class="mb-4">We Are Pioneers In The World Of Renewable Energy</h1>
        </div>

        <div class="row">
        <?php
        while ($row = mysqli_fetch_array($res)) {
            $stars = str_repeat("⭐", $row['prod_rating']);
            $item = <<<DELIMETER
                <div class='col-md-6 col-lg-4 mb-4 wow fadeInUp' data-wow-delay='0.3s'>
                    <div class='service-item rounded overflow-hidden'>
                        <img class='img-fluid' src='{$row['prod_img']}' alt=''>
                        <div class='position-relative p-4 pt-0'>
                            <div class='service-icon'>
                                <i class='{$row['prod_icon']} fa-3x'></i>
                            </div>
                            <h4 class='mb-3'>{$row['prod_name']}</h4>
                            <p>{$row['prod_desc_short']}</p>
                            <div class='mt-3'>
                                <a href='items.php?prod_id={$row['prod_id']}' class='btn btn-primary rounded-pill py-3 px-4'>View Details</a>
                                <span>{$stars}</span>
                            </div>
                        </div>
                    </div>
                </div>
            DELIMETER;
            echo $item;
        }
/*WHY THE CURLY BRACES???
    The curly braces help PHP know exactly which part is the variable inside the string.
    Without the curly braces, PHP would treat everything as plain text, and it wouldn't
    replace the variable with its value.*/

    /*WHY SHOULD I MAKE ALL THE VARIABLES NOT ONLY PRICE ONE ???
    This happens because PHP can guess where the variable begins and ends in certain 
    simple contexts, such as when it's directly inside the string, and it's not 
    immediately adjacent to other characters that might confuse PHP.
    */
        ?>
        </div>
    </div>
</div>

<a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>
<?php include("2DownButton.php"); ?>
<?php include("footer.php"); ?>
</body>
</html>
