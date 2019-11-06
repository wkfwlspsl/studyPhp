<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-05
 * Time: 오전 10:00
 */

    include 'dbConnect.php';

    $uploaddir = 'C:\xampp\htdocs\fileuploaddir\\';
    $f_num = $_GET["file"];

    $result = mysqli_query($con,"select * from files where f_num=$f_num");

    $file_dir = '';
    if($row = mysqli_fetch_array($result)){
        $file_dir = $uploaddir.$row['server_file_name'];
        header('Content-Type: application/x-octetstream');
        header('Content-Length: '.filesize($file_dir));
        header('Content-Disposition: attachment; filename='.$row['original_file_name']);
        header('Content-Transfer-Encoding: binary');
    }

    $fp = fopen($file_dir,'r');
    fpassthru($fp);
    fclose($fp);

    mysqli_close($con);
?>