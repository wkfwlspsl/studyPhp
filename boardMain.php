<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script src="js/bootstrap.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/myscript.js"></script>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2 class="text-center">자유게시판</h2>
<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-01
 * Time: 오전 10:36
 */
    session_start();
    if($_SESSION["loginInfo"]) {

        echo "<h5 class='pull-right'><b>".$_SESSION["nickName"]."</b>님</h5><br><br>";
        ?>
        <button class="btn btn-danger pull-right" onclick="location='logout.php'">로그아웃</button>
        <?php
        //db connect
        include 'dbConnect.php';

        //paging
        $page_per_record = 10;  //화면에 표시할 자료 개수(페이지당 레코드 수)
        $block_per_page = 5;    //화면에 표시할 페이지 번호 개수(블록당 페이지 수)
        $now_page = '';          //현재 선택된 페이지 번호(GET, POST 등 외부로부터 넘어온다)
        if(isset($_GET['pageNum'])){
            $now_page = $_GET['pageNum'];
        }else{
            $now_page = 1;
        }

        $total_record = '';        //전체 레코드수는 db를 통해 얻어온다
        $total_page = '';//전체 페이지 개수
        $total_block = '';  //전체 블록 개수
        $now_block = '';      //현재 페이지가 속해있는 블록 번호
        $start_record = '';     //가져올 레코드 시작 번호
        $start_page = '';       //가져올 페이지 시작 번호
        $end_page = ''; //가져올 페이지 끝 번호

        $boardList = '';

        $searchData = '';
        $searchType = '';

        //검색데이터가 있으면
        if(isset($_GET['searchData']) && $_GET['searchData'] != ''){
            $searchData = $_GET['searchData'];
            $searchType = $_GET['searchType'];

            $result = mysqli_query($con, "select * from board where $searchType like '%$searchData%' and board_type=1");
            $total_record = mysqli_num_rows($result);

            $total_page = ceil($total_record / $page_per_record) + 1;//전페 페이지 개수
            $total_block = ceil($total_page / $block_per_page);  //전체 블록 개수
            $now_block = ceil($now_page / $block_per_page);      //현재 페이지가 속해있는 블록 번호
            $start_record = (($now_page-1) * $page_per_record);     //가져올 레코드 시작 번호
            $start_page = (($now_block-1) * $block_per_page) + 1;       //가져올 페이지 시작 번호
            $end_page = ( ($start_page+$block_per_page) <= $total_page )? ($start_page+$block_per_page) : $total_page; //가져올 페이지 끝 번호

            $boardList = mysqli_query($con, "select * from board where $searchType like '%$searchData%' and board_type=1 order by ref desc, re_step asc limit $start_record, $page_per_record");
        }
        else{
            $result = mysqli_query($con,"select count(*) num from board where board_type=1");
            $total_record = mysqli_fetch_array($result)['num'];

            $total_page = ceil($total_record / $page_per_record) + 1;//전페 페이지 개수
            $total_block = ceil($total_page / $block_per_page);  //전체 블록 개수
            $now_block = ceil($now_page / $block_per_page);      //현재 페이지가 속해있는 블록 번호
            $start_record = (($now_page-1) * $page_per_record);     //가져올 레코드 시작 번호
            $start_page = (($now_block-1) * $block_per_page) + 1;       //가져올 페이지 시작 번호
            $end_page = ( ($start_page+$block_per_page) <= $total_page )? ($start_page+$block_per_page) : $total_page; //가져올 페이지 끝 번호

            $boardList = mysqli_query($con,"select * from board where board_type=1 order by ref desc, re_step asc limit $start_record, $page_per_record");
        }

        ?>

        <br><br>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>작성일</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $j = 0;
            while ($row = mysqli_fetch_assoc($boardList)) {
                $b_num = $row["b_num"];
                $result = mysqli_query($con,"select * from reply where b_num='$b_num'");
                $reply = mysqli_num_rows($result);
                ?>
                <tr>
                    <td>
                        <?php
                            //전체글 수 - (페이지당 글 수 * (현재페이지-1)) / 글 번호 정렬해주는 수식
                            $buyNum = $total_record - ($page_per_record*($now_page-1));
                            $num = $buyNum - $j;
                            echo $num;
                        ?>
                    </td>
                    <td>
                        <a href="content.php?b_num=<?=$b_num?>&pageNum=<?=$now_page?>&searchType=<?=$searchType?>&searchData=<?=$searchData?>">
                            <?php
                            for($i=0; $i<$row["re_level"]; $i++){
                                echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                                if($i == $row["re_level"] -1)
                                    echo "└ ";
                            }
                            echo $row["title"];
                            if($row["filedata"]){
                                echo " <img src='img/ico_file.gif'>";
                            }
                            if($reply){
                                echo "<b> [".$reply."]</b>";
                            }
                            ?>
                        </a>
                    </td>
                    <td><?php echo $row["author"]; ?></td>
                    <td><?php echo $row["reg_date"]; ?></td>
                </tr>
                <?php
                $j++;
            }
            ?>
            </tbody>
        </table>
        <hr/>
        <button class="btn btn-primary pull-left" onclick="location='boardMain.php'">전체목록</button>
        <button class="btn btn-primary pull-right" onclick="location='writeForm.php'">글작성</button>
        <div class="text-center">
            <ul class="pagination">
                <?php
                $pre = $start_page-1;
                //1페이지 밑으로 안가게 조건 걸어주기
                if($pre <= 0)
                    $pre = 1;

                //가장 마지막 페이지
                $last_page = $total_page-1;
                if($last_page <= 0)
                    $last_page = 1;

                //마지막 페이지 안넘어가게 조건
                //▷ 버튼은 다음 블럭의 첫 페이지가 오는걸로
                $next_block = $now_block + 1;
                $next_block_start_page = (($next_block-1) * $block_per_page) + 1;
                if($next_block > $total_block){
                    $next_block_start_page = $last_page;
                }

                echo "<li><a href='boardMain.php?pageNum=1&searchType=$searchType&searchData=$searchData'>◁◁</a></li>";
                echo "<li><a href='boardMain.php?pageNum=$pre&searchType=$searchType&searchData=$searchData'>◁</a></li>";

                $i = $start_page;
                do{
                    if($now_page == $i)
                        echo "<li><a href='boardMain.php?pageNum=$i&searchType=$searchType&searchData=$searchData'><b>".$i."</b></a></li>";
                    else
                        echo "<li><a href='boardMain.php?pageNum=$i&searchType=$searchType&searchData=$searchData'>".$i."</a></li>";
                    $i++;
                }while($i < $end_page);

                echo "<li><a href='boardMain.php?pageNum=$next_block_start_page&searchType=$searchType&searchData=$searchData'>▷</a></li>";
                echo "<li><a href='boardMain.php?pageNum=$last_page&searchType=$searchType&searchData=$searchData'>▷▷</a></li>";
                ?>
            </ul>
        </div>


        <br>
        <div class="text-center">
            <form method="get" action="boardMain.php">
                <select name="searchType">
                    <option value="title">제목</option>
                    <option value="content">내용</option>
                    <option value="author">작성자</option>
                </select>
                <input type="text" name="searchData">
                <input class="btn btn-default btn-sm" type="submit" value="검색">
            </form>
        </div>
        <?php
        mysqli_close($con);
    }
    else{
        echo "로그인 세션이 없습니다.<br> 잠시 후 로그인 화면으로 돌아갑니다.";
        echo "<meta http-equiv='refresh' content='2; url=loginPage.php'>";
    }
?>

</body>