<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script src="js/bootstrap.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/myscript.js"></script>
<head>
    <meta charset="utf-8">
</head>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-12
 * Time: 오후 2:07
 */

    include 'dbConnect.php';

    $id = $_POST["id"];
    $passwd = $_POST["passwd1"];
    $name = $_POST["name"];
    $gender = $_POST["gender"];

    //비밀번호 암호화 작업
    $hash = password_hash($passwd, PASSWORD_DEFAULT); //여기서 반환하는 hash값을 DB에 저장

    mysqli_query($con, "insert into member(id, passwd, name, gender, join_date) VALUES('$id', '$hash', '$name', '$gender', sysdate())");

    echo "<meta http-equiv='refresh' content='0; url=loginpage.php'>";
?>