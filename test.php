<?php
/**
 * Created by IntelliJ IDEA.
 * User: lenovo
 * Date: 2017-06-02
 * Time: 오후 1:34
 */
?>
<form enctype="multipart/form-data" action="testPro.php" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="30000000">
    <input type="file" name="userfile[]">
    <input type="submit" value="확인">
</form>