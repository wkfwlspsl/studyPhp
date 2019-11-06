<head>
    <meta charset="utf-8">
</head>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-01
 * Time: 오후 4:29
 */

    session_start();

    if($_SESSION["loginInfo"]){
        unset($_SESSION["loginInfo"]);
        unset($_SESSION["nickName"]);
    }

    echo "<meta http-equiv='refresh' content='0; url=loginPage.php' >";
?>