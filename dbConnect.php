<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-02
 * Time: 오전 11:07
 */

    $con = mysqli_connect("localhost","root", "1234","phpboard");
    //mysql character set을 utf8로
    mysqli_set_charset($con, "utf8");

    //sql 인젝션 예방하기위한 filter함수
    function filter($nameasdferwer){
        //스크립트 제거
        $nameasdferwer=preg_replace("!<script(.*?)<\/script>!is","",$nameasdferwer);
        //html엔티티문자변환
        $nameasdferwer = htmlspecialchars($nameasdferwer);
        //모든html태그제거
        $nameasdferwer = strip_tags($nameasdferwer);
        return $nameasdferwer;
    }
?>