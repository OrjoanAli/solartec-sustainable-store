<?php require_once "config.php";?>

<div class="list-group">
    <?php 
    $result = query("select * from categories");
    while ($row = mysqli_fetch_array($result)){
        $string = "<a href=\"service.php?id=$row[cat_id]\" class=\"list-group-item\">$row[cat_name] </a> ";
        //DELIMETER is allows writing multi-line strings without needing concatenation (.) or escape characters (\"
        //Easier to Write Multi-line Strings → No need for concatenation (.).Faster than Concatenation
        echo $string;
    }
    ?>
</div>