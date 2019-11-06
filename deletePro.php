<head>
    <meta charset="utf-8">
</head>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-01
 * Time: 오후 3:53
 */
    session_start();
    if($_SESSION["loginInfo"]) {
        //db connect
        include 'dbConnect.php';

        $b_num = $_GET["b_num"];

        mysqli_query($con, "update board set board_type = 0, del_date = sysdate() where b_num = '$b_num'");
        mysqli_query($con, "delete from reply where b_num='$b_num'");
        mysqli_query($con, "delete from files where b_num='$b_num'");

        echo "<meta http-equiv='refresh' content='0; url=boardMain.php'>";

        mysqli_close($con);
    }
    else{
        echo "로그인 세션이 없습니다.<br> 잠시 후 로그인 화면으로 돌아갑니다.";
        echo "<meta http-equiv='refresh' content='2; url=loginPage.php'>";
    }
?>