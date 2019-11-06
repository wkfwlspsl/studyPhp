<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-01
 * Time: 오전 9:45
 */
    header("Content-Type:application/json");
    //db connect
    include 'dbConnect.php';

    //session start
    session_start();

    //데이터 받아오기
    $id = $_POST["id"];
    $passwd = $_POST["passwd"];

    //query
    $result = mysqli_query($con, "select * from member where id = '$id'");

    $response = array();
    $response["success"] = false;


    if($row = mysqli_fetch_array($result)){
        //아이디가 존재하면

        //비밀번호 같나 비교 / strcmp() 두 스트링이 같으면 0  다르면 1 리턴
        if(password_verify($passwd, $row["passwd"])){
            //아이디 비밀번호 일치!
            $_SESSION["loginInfo"] = $row["m_num"];
            $_SESSION["nickName"] = $row["name"];

            $response["success"] = true;
        }
    }

    mysqli_close($con);
    echo json_encode($response);
?>