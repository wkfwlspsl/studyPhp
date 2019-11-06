<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-05
 * Time: 오후 4:34
 */
    header("Content-Type:application/json");
    session_start();
    //db connect
    include 'dbConnect.php';

    $b_num = $_POST['b_num'];
    $pageNum = $_POST['pageNum'];
    $m_num = $_SESSION['loginInfo'];
    $check = '';
    $r_num = '';
    if(isset($_POST["r_num"])){
        $r_num = $_POST["r_num"];
        $check = mysqli_query($con, "select * from reply where b_num='$b_num' and m_num='$m_num' and r_num='$r_num'");
    }
    else{
        $check = mysqli_query($con, "select * from board where b_num='$b_num' and m_num='$m_num'");
    }

    $response = array();
    $response["success"] = false;

    if(mysqli_num_rows($check)) {
        //글작성자와 로그인한 사람이 일치
        $response["success"] = true;
        $response["b_num"] = $b_num;
        $response["pageNum"] = $pageNum;
        $response["r_num"] = $r_num;
        $response["m_num"] = $m_num;
    }

    mysqli_close($con);
    echo json_encode($response);
?>
