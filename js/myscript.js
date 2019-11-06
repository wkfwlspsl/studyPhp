/**
 * Created by lenovo on 2017-06-09.
 */


$(document).ready(function(){

    //로그인 ajax
    $('button[name=loginbtn]').click(function () {
        $.ajax({
            url:'loginPro.php',
            type: 'post',
            dataType:'JSON',
            data: { 'id': $('input[name=id]').val(), 'passwd': $('input[name=passwd]').val() },
            success: function(data){
                if(data.success){
                    location.href = 'boardMain.php';
                }
                else{
                    alert("아이디와 비밀번호를 다시 확인해주세요");
                }
            }
        });
    });

    //file download count ajax
    $('#downlink').click(function () {
        $.ajax({
            url:'filecountAjax.php',
            type: 'post',
            data: { 'f_num': this.getAttribute("name")},
            success: function(){
                location.reload();
            }
        });
    });

    //댓글 등록 ajax
    $('input[name=ok]').click(function () {
        $.ajax({
            url:'replyWritePro.php',
            type: 'post',
            data: { 'b_num': $('input[name=b_num]').val(), 'replyContent' : $('input[name=replyContent]').val()},
            success: function(){
                location.reload();

            }
        });
    });

    //글 수정 권한 확인 ajax
    $('input[name=modify]').click(function () {
        $.ajax({
            url:'authorCheck.php',
            type:'post',
            dataType:'JSON',
            data:{ 'b_num': $('input[name=b_num]').val(), 'pageNum': $('input[name=pageNum]').val()},
            success:function (data) {
                if(data.success){
                    location.href = 'modifyForm.php?b_num='+data.b_num+'&pageNum='+data.pageNum;
                }
                else{
                    alert("수정 권한이 없습니다.");
                }
            }
        });
    });

    //글 삭제 권한 확인 ajax
    $('input[name=delete]').click(function () {
        $.ajax({
            url:'authorCheck.php',
            type:'post',
            dataType:'JSON',
            data:{ 'b_num': $('input[name=b_num]').val(), 'pageNum': $('input[name=pageNum]').val()},
            success:function (data) {
                if(data.success){
                    if(confirm("정말 삭제하시겠습니까?")){
                        location.href = 'deletePro.php?b_num='+data.b_num+'&pageNum='+data.pageNum;
                    }
                }
                else{
                    alert("삭제 권한이 없습니다.");
                }
            }
        });
    });

    //댓글 삭제 권한 ajax
    $('button[name=delreply]').click(function () {

        $.ajax({
            url:'authorCheck.php',
            type:'post',
            dataType:'JSON',
            data:{ 'b_num': $('input[name=b_num]').val(), 'pageNum': $('input[name=pageNum]').val(), 'r_num' : $(this).val() },
            success:function (data) {
                if(data.success){
                    if(confirm("정말 삭제하시겠습니까?")){
                        location.href = 'replydeletePro.php?r_num='+data.r_num+'&pageNum='+data.pageNum+'&b_num='+data.b_num;
                    }
                }
                else{
                    alert("삭제 권한이 없습니다.");
                }
            }
        });
    });

    //글 수정 - 파일 삭제 ajax
    $('#filedel').click(function () {
        if(confirm("확인을 누르면 파일이 영구 삭제 됩니다.\n파일을 삭제하시겠습니까?")){
            $.ajax({
                url:'filedeletePro.php',
                type: 'post',
                data: { 'b_num': $('input[name=b_num]').val(), 'f_num' : $('#filedel').val()},
                success: function(){
                    location.reload();
                }
            });
        }
    });

    $('input[name=fileplus]').click(function () {
        //부모객체 얻어오고, li노드, 파일노드, 삭제버튼노드 생성
        var parentElement = document.getElementById("fileList");
        var liElement = document.createElement("li");
        var newfileElement = document.createElement("input");
        var newdelbtnElement = document.createElement("button");

        //attribute 세팅
        newfileElement.setAttribute("type", "file");
        newfileElement.setAttribute("name", "userfile[]");

        newdelbtnElement.setAttribute("type", "button");
        newdelbtnElement.setAttribute("class", "btn-danger");
        newdelbtnElement.setAttribute("onclick","delNode(this)");
        newdelbtnElement.innerText = "-";

        //li노드에 append
        liElement.appendChild(newfileElement);
        liElement.appendChild(newdelbtnElement);

        //부모객체에 append
        parentElement.appendChild(liElement);
    });
});

//파일등록 돔 삭제부분
function delNode(btn){
    var delNode = btn.parentNode;

    delNode.remove();
}

//회원가입 체크부분
function joinCheck(){
    //입력 안 된것들 체크
    if(!joinform.id.value){
        alert("아이디를 입력하세요");
        return false;
    }
    else if(!joinform.passwd1.value){
        alert("비밀번호를 입력하세요");
        return false;
    }
    else if(!joinform.passwd2.value){
        alert("비밀번호 확인을 입력하세요");
        return false;
    }
    else if(!joinform.name.value){
        alert("이름을 입력하세요");
        return false;
    }
    else if(joinform.passwd1.value != joinform.passwd2.value){
        //비밀번호 일치 체크
        alert("비밀번호가 일치하지 않습니다");
        return false;
    }
    else{
        return true;
    }
}