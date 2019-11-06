<head>
    <meta charset="utf-8">
</head>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-01
 * Time: 오전 10:57
 */
    session_start();
    if($_SESSION["loginInfo"]) {
        //db connect
        include 'dbConnect.php';

        //데이터 받아오기
        $title = filter($_POST["title"]);
        $content = filter($_POST["content"]);
        $parentNum = $_POST["parentNum"];
        $origin = $_POST["origin"];
        $MAX_FILE_SIZE = $_POST["MAX_FILE_SIZE"];

        //파일이 넘어왔다면 넘어 온 파일의 용량을 먼저 체크해서
        //용량이 max용량보다 크다면 글을 등록할 수 없고 뒤로가게
        if ($_FILES['userfile']['name']){
            //파일이 넘어왔으면 사이즈 비교
            for($i=0; $i<count($_FILES["userfile"]["name"]); $i++){
                //파일이 넘어왔는데 용량이 커서 업로드 되지않아 tmp_name이 없는경우
                if($_FILES['userfile']['name'][$i] != '' && $_FILES['userfile']["tmp_name"][$i] == ''){
                    echo "<script>alert('파일용량초과 최대용량 30MB".$_FILES['userfile']['name']." ');history.back();</script>";
                    exit;
                }
            }
        }

        //세션에서 로그인 정보 꺼내기
        $loginInfo = $_SESSION["loginInfo"];
        $name = $_SESSION["nickName"];

        //board 테이블에 데이터 insert
        $result = mysqli_query($con, "insert into board(m_num, title, content, author, reg_date, mod_date) values('$loginInfo', '$title', '$content', '$name', sysdate(), sysdate())");

        //방금 넣은 게시글의 b_num 얻어오기
        $bnumresult = mysqli_query($con, "select max(b_num) b_num from board");
        $b_num;
        if($row = mysqli_fetch_array($bnumresult)){
            $b_num = $row['b_num'];
        }

        //origin 글 일경우. 답글이 아닌 경우
        if($origin){
            mysqli_query($con, "update board set ref = '$b_num', re_step=0, re_level=0 where b_num='$b_num'");
        }
        else{



            //답글인 경우 ref부모것과 같게, re_step,re_level 부모+1
            $parentResult = mysqli_query($con, "select * from board where b_num = '$parentNum'");
            $re_step = '';
            $ref = '';
            if($row = mysqli_fetch_array($parentResult)){


                $ref = $row["ref"];
                $re_step = $row["re_step"];
                $re_level = $row["re_level"];

                //같은그룹내에서 부모글의 re_step보다 크고 re_level이 작거나 같은것들 중 re_step이 가장 작은값을 찾아서
                $queryResult = mysqli_query($con,"select min(re_step) min_step from board where ref = '$ref' and re_step > '$re_step' and re_level <= '$re_level'");

                //그 값이 만약 null이면 맨 밑에 와야하는 글이고 null이 아니면 중간에 와야하는 글
                if($r1 = mysqli_fetch_array($queryResult)){
                    $min_step = $r1["min_step"];
                    if($min_step == null){
                        //맨밑
                        $maxResult = mysqli_query($con, "select max(re_step)+1 max_step from board where ref='$ref'");
                        if($r2 = mysqli_fetch_array($maxResult)){
                            $re_step = $r2["max_step"];
                        }
                    }
                    else{
                        //중간에 끼는
                        mysqli_query($con,"update board set re_step = re_step+1 where ref='$ref' and re_step >= '$min_step'");
                    }
                }

                $re_level = $re_level + 1;

                mysqli_query($con, "update board set ref = '$ref', re_step='$re_step', re_level='$re_level' where b_num='$b_num'");

            }
        }


        //board insert 성공 && 파일이 넘어왔을 시
        if ($result && $_FILES['userfile']['name']) {

            for($i=0; $i<count($_FILES["userfile"]["name"]); $i++){
                //파일업로드
                //파일저장디렉토리
                $uploaddir = 'C:\xampp\htdocs\fileuploaddir\\';
                //올린날짜+파일오리지널명 ==> 서버에 업로드 될 이름 / 여기서 한글이름이면 올린날짜로만
                if(preg_match("/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/",$_FILES['userfile']['name'][$i])){
                    //업로드 파일명에 한글이 포함되어있으면
                    $server_file_name = date("YmdHis");
                }else{
                    //한글이 포함되어있지 않으면
                    $server_file_name = date("YmdHis") . basename($_FILES['userfile']['name'][$i]);
                }

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