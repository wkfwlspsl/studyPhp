<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script src="js/bootstrap.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-02
 * Time: 오후 1:34
 */

    if($_FILES['userfile']['name'] != 'Array'){
        echo "dd";
    }
    echo $_FILES['userfile']['name'];
?>