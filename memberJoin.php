<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<script src="js/bootstrap.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/myscript.js"></script>
<head>
    <meta charset="utf-8">
</head>
<body>
    <div class="container">
        <h2 class="text-center">회원가입</h2>
        <form class="form-signin" name="joinform" method="post" action="memberJoinPro.php" onsubmit="return joinCheck()">
            ID<input class="form-control" type="text" name="id">
            PASSWD<input class="form-control" type="password" name="passwd1">
            PASSWD-CHECK<input class="form-control" type="password" name="passwd2">
            NAME<input class="form-control" type="text" name="name">
            GENDER<select class="form-control" name="gender">
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select><br>
            <input class="btn btn-lg btn-primary btn-block" type="submit" value="가입">
        </form>
    </div>
</body>
