<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-09
 * Time: 오후 2:19
 */

    include 'dbConnect.php';
    session_start();

    $f_num = $_POST["f_num"];

    mysqli_query($con,"update files set download_count = download_count+1 where f_num = '$f_num'");

    mysqli_close($con);

?>