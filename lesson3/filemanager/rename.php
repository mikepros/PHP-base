<?php

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $file= $_POST['file'];
    $dir = $_POST['dir'];
    $new_name=$_POST['rename_to'];
    rename("$dir/$file","$dir/$new_name");
    header("Location:index.php");
}
else{
    $file=$_GET['file'];
    $dir = $_GET['dir'];
    ?>
    <form method='post'>
        <label for="rename_to">New name: </label>
		<input name='rename_to' id="rename_to" value="<?=$file;?>">
        <input type="hidden" name="dir" value="<?=$dir?>">
        <input type="hidden" name="file" value="<?=$file?>">
        <input type='submit' value="Rename">
    </form>
    <?php
}