<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script src="js/bootstrap.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/myscript.js"></script>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2 class="text-center">글쓰기</h2>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-01
 * Time: 오전 10:40
 */
    session_start();
    if($_SESSION["loginInfo"]) {
        $origin = '';
        $parentNum = '';
        //답글인지 아닌지 판단. 답글이면 b_num이 넘어옴
        //origin이 1인 경우만 원글 아니면 답글로 판단
        if(isset($_GET['b_num'])){
            $origin = 0;
            $parentNum = $_GET['b_num'];
        }else
            $origin = 1;

        echo "<h5 class='pull-right'><b>".$_SESSION["nickName"]."</b>님</h5><br><br>";

        ?>

        <form enctype="multipart/form-data" method="post" action="writePro.php">
            <input type="hidden" name="MAX_FILE_SIZE" value="30000000">
            <input type="hidden" name="origin" value="<?=$origin?>">
            <input type="hidden" name="parentNum" value="<?=$parentNum?>">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th>제목</th>
                    <td><input type="text" name="title"></td>
                </tr>
                <tr>
                    <th>내용</th>
                    <td>
                        <textarea name="content" cols="100" rows="10" onscroll="true"></textarea>
                    </td>
                </tr>
                <tr>
                    <th>첨부파일</th>
                    <td>
                        <ul id="fileList">
                            <li><input type="file" name="userfile[]"></li>
                        </ul>
                        <input type="button" class="btn-success" value="+" name="fileplus">
                    </td>
                </tr>
                <tr style="text-align: center;">
                    <td colspan="2">
                        <input class="btn btn-default" type="submit" value="작성">
                        <input class="btn btn-default" type="button" value="취소" onclick="location='boardMain.php'">
                    </td>
                </tr>
                </tbody>
            </table>

        </form>

        <?php
    }
    else{
        echo "로그인 세션이 없습니다.<br> 잠시 후 로그인 화면으로 돌아갑니다.";
        echo "<meta http-equiv='refresh' content='2; url=loginPage.php'>";
    }
        ?>
</body>