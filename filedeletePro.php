<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-09
 * Time: 오전 9:32
 */
    session_start();

    if($_SESSION["loginInfo"]) {
        //db connect
        include 'dbConnect.php';
        $b_num = $_POST["b_num"];
        $f_num = $_POST["f_num"];
        //파일삭제
        mysqli_query($con, "delete from files where f_num='$f_num'");

        //해당 글에 파일이 있는지 확인
        $result = mysqli_query($con,"select * from files where b_num='$b_num'");
        if(!$row = mysqli_fetch_array($result)){
            //글에 파일이 하나도 없는 경우
            mysqli_query($con,"update board set filedata=0 where b_num='$b_num'");
        }

        mysqli_close($con);
    }
?>