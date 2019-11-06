<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script src="js/bootstrap.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/myscript.js"></script>
<head>
    <meta charset="utf-8">
</head>
<body>
<h2 class="text-center">글내용</h2>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-01
 * Time: 오후 1:11
 */
    session_start();
    if($_SESSION["loginInfo"]) {

        //db connect
        include 'dbConnect.php';

        $b_num = $_GET["b_num"];
        $now_page = $_GET["pageNum"];

        $searchData = '';
        $searchType = '';

        if(isset($_GET['searchData']) && $_GET['searchData'] != '') {
            $searchData = $_GET['searchData'];
            $searchType = $_GET['searchType'];
        }

        echo "<h5 class='pull-right'><b>".$_SESSION["nickName"]."</b>님</h5><br><br>";

        $content = mysqli_query($con, "select * from board where b_num='$b_num'");

        if($row = mysqli_fetch_array($content)){
            //삭제된 글로 비정상 접근시
            if($row["board_type"]==0){
                echo "<script>alert('비정상 접근입니다.');history.back();</script>";
                exit;
            }
            ?>
            <table class="table table-striped">
                <input type="hidden" name="b_num" value="<?=$b_num?>">
                <input type="hidden" name="pageNum" value="<?=$now_page?>">
                <tbody>
                <tr>
                    <th>제목</th>
                    <td><?php echo $row["title"] ?></td>
                    <th>작성자</th>
                    <td><?php echo $row["author"] ?></td>
                    <th>작성일</th>
                    <td><?php echo $row["reg_date"] ?></td>
                    <th>수정일</th>
                    <td><?php echo $row["mod_date"] ?></td>
                </tr>
                <tr>
                    <th>내용</th>
                    <td colspan="7">
                        <textarea name="content" cols="100" rows="10" readonly onscroll="true"><?php echo $row["content"] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th>첨부파일</th>
                    <td colspan='8'>
                        <?php
                            $fileresult = mysqli_query($con, "select * from files where b_num='$b_num'");
                            if($filerows = mysqli_fetch_array($fileresult)){
                                do{
                                    $f_num = $filerows['f_num'];
                                    echo "<a href='filedownPro.php?file=$f_num' id='downlink' name='$f_num'>".$filerows['original_file_name']."</a>&nbsp;&nbsp;";
                                    echo "다운로드 횟수 : ".$filerows['download_count']."<br>";
                                }while($filerows = mysqli_fetch_array($fileresult));
                            }
                            else{
                                echo "<td colspan='8'>".$fileresult->lengths."</td>";
                            }
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <hr/>
            <br><br>
        <?php
        }else{
            //url을 통해 없는글로 접근시
            echo "<script>alert('비정상 접근입니다.');history.back();</script>";
            exit;
        }
        ?>
        <div id="reply">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th colspan="3">댓글</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $result = mysqli_query($con, "select * from reply where b_num='$b_num'");
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <th><?=$row["author"]?></th>
                                <td><?=$row["content"]?></td>
                                <td><?=$row["reg_date"]?></td>
                                <td><button type="button" name="delreply" value="<?=$row['r_num']?>" class="btn-danger">X</button></td>
                            </tr>
                        <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
        <hr/>
        <br><br>
        <div class="container">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>댓글작성</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <input type="text" name="replyContent">
                        <input class="btn btn-default" type="button" value="등록" name="ok">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <hr/>
        <input class="btn btn-primary pull-right" type="button" value="답글쓰기" onclick="location='writeForm.php?b_num=<?=$b_num?>'">
        <input class="btn btn-primary pull-left" type="button" value="목록" onclick="location='boardMain.php?pageNum=<?=$now_page?>&searchType=<?=$searchType?>&searchData=<?=$searchData?>'">
        <div class="text-center">
            <input class="btn btn-default btn-primary" type="button" name="modify" value="수정">
            <input class="btn btn-default btn-danger" type="button" name="delete" value="삭제">
        </div>
        <br><br>
</body>
<?php
    }
    else{
        echo "로그인 세션이 없습니다.<br> 잠시 후 로그인 화면으로 돌아갑니다.";
        echo "<meta http-equiv='refresh' content='2; url=loginPage.php'>";
    }
?>