<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script src="js/bootstrap.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/myscript.js"></script>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2 class="text-center">글수정</h2>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-01
 * Time: 오후 4:08
 */
    session_start();
    if($_SESSION["loginInfo"]) {
        //db connect
        include 'dbConnect.php';

        $b_num = $_GET["b_num"];
        $pageNum = $_GET["pageNum"];
        $m_num = $_SESSION["loginInfo"];

        $content = mysqli_query($con, "select * from board where b_num='$b_num'");

        if ($row = mysqli_fetch_array($content)) {
            //수정권한 없는 글에 수정폼 비정상 접근시
            if( strcmp($row["m_num"], $m_num) ){
                echo "<script>alert('비정상 접근입니다.');history.back();</script>";
                exit;
            }
            ?>
            <form method="post" action="modifyPro.php" enctype="multipart/form-data">
                <input type="hidden" name="b_num" value="<?php echo $b_num ?>">
                <table class="table">
                    <tbody>
                    <tr>
                        <th>제목</th>
                        <td><input type="text" name="title" value="<?php echo $row["title"] ?>"></td>
                    </tr>
                    <tr>
                        <th>내용</th>
                        <td>
                            <textarea name="content" cols="100" rows="10" onscroll="true"><?php echo $row["content"] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>첨부파일</th>
                        <td>
                            <?php
                                $fileresult = mysqli_query($con,"select * from files where b_num='$b_num'");
                                while($filerows = mysqli_fetch_array($fileresult)){
                                    $f_num = $filerows["f_num"];
                                    echo $filerows["original_file_name"]."&nbsp;<button class='btn-danger' id='filedel' value='$f_num'>삭제</button><br>";
                                }
                            ?>
                            <hr>
                            <ul id="fileList">
                                <li><input type="file" name="userfile[]"></li>
                            </ul>
                            <input type="button" class="btn-success" value="+" name="fileplus">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="text-center">
                                <input class="btn btn-primary" type="submit" value="수정">
                                <input class="btn btn-danger" type="button" value="취소" onclick="location='content.php?b_num=<?=$b_num?>&pageNum=<?=$pageNum?>'">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <?php
        }
        else{
            //url을 통해 없는글로 수정 접근시
            echo "<script>alert('비정상 접근입니다.');history.back();</script>";
            exit;
        }
        mysqli_close($con);
    }
    else{
        echo "로그인 세션이 없습니다.<br> 잠시 후 로그인 화면으로 돌아갑니다.";
        echo "<meta http-equiv='refresh' content='2; url=loginPage.php'>";
    }
?>
</body>
