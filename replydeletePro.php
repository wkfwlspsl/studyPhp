<head>
    <meta charset="utf-8">
</head>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-08
 * Time: 오전 11:23
 */
    session_start();
    if($_SESSION["loginInfo"]) {
        //db connect
        include 'dbConnect.php';

        $pageNum = $_GET["pageNum"];
        $b_num = $_GET["b_num"];
        $r_num = $_GET["r_num"];

        mysqli_query($con, "delete from reply where r_num='$r_num'");

        echo "<meta http-equiv='refresh' content='0; url=content.php?b_num=$b_num&pageNum=$pageNum'>";

        mysqli_close($con);
    }
    else{
        echo "로그인 세션이 없습니다.<br> 잠시 후 로그인 화면으로 돌아갑니다.";
        echo "<meta http-equiv='refresh' content='2; url=loginPage.php'>";
    }
?>