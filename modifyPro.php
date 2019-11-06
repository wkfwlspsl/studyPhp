<head>
    <meta charset="utf-8">
</head>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-01
 * Time: 오후 4:17
 */

    session_start();
    if($_SESSION["loginInfo"]) {
        //db connect
        include 'dbConnect.php';

        $b_num = $_POST["b_num"];
        $title = filter($_POST["title"]);
        $content = filter(["content"]);

        $result = mysqli_query($con, "update board set title='$title', content='$content', mod_date=sysdate() where b_num='$b_num'");


        //board insert 성공 && 파일이 넘어왔을 시
        if ($result && $_FILES['userfile']['name']) {
            for($i=0; $i<count($_FILES["userfile"]["name"]); $i++){
                //파일업로드
                //파일저장디렉토리
                $uploaddir = 'C:\xampp\htdocs\fileuploaddir\\';
                //올린날짜+파일오리지널명 ==> 서버에 업로드 될 이름
                $server_file_name = date("YmdHis") . basename($_FILES['userfile']['name'][$i]);
                var_dump($server_file_name);
                //디렉토리 + 서버에 업로드될 파일명
                $uploadfile = $uploaddir.$server_file_name;

                $original_file_name = $_FILES['userfile']['name'][$i];
                $size = $_FILES['userfile']['size'][$i];

                if (move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $uploadfile)) {
                    //파일업로드가 완료되면 데이터베이스에 넣기
                    mysqli_query($con, "insert into files(b_num, original_file_name, server_file_name, size) values('$b_num', '$original_file_name', '$server_file_name', '$size')");
                    //board테이블 파일유무 업데이트
                    mysqli_query($con, "update board set filedata = 1 where b_num='$b_num'");
                }
            }
            echo "<meta http-equiv='refresh' content='0; url=boardMain.php'>";
        }
        elseif ($result){
            echo "<meta http-equiv='refresh' content='0; url=boardMain.php'>";
        }

        mysqli_close($con);
    }
    else{
        echo "로그인 세션이 없습니다.<br> 잠시 후 로그인 화면으로 돌아갑니다.";
        echo "<meta http-equiv='refresh' content='2; url=loginPage.php'>";
    }
?>