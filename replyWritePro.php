<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-01
 * Time: 오후 5:15
 */

    session_start();

    $b_num = $_POST["b_num"];
    $replyContent = $_POST["replyContent"];
    $m_num = $_SESSION["loginInfo"];
    $name = $_SESSION["nickName"];

    //db connect
    include 'dbConnect.php';

    if($replyContent) {
        mysqli_query($con, "insert into reply(b_num, m_num, content, reg_date, mod_date, author) values('$b_num', '$m_num', '$replyContent', sysdate(), sysdate(), '$name')");
    }

    mysqli_close($con);
?>