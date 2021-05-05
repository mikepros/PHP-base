<?php

if ($_SERVER['REQUEST_METHOD']=='POST'){
    $dir=$_POST['dir'];
    $file=$_POST['file'];
    $new_content=$_POST['new_content'];
    file_put_contents($dir.'/'.$file,$new_content);
    header("Location:read.php?file=$file");
}
else{
    $dir=$_GET['dir'];
    $file=$_GET['file'];
    $content=file_get_contents($dir.'/'.$file);

    ?>
    <form method='post'>
		<textarea name='new_content'>
			<?=$content;?>
		</textarea>
        <input type=hidden value=<?=$file;?>   name=file>
        <br>
        <input type='submit'>
    </form>
    <?php
}