<?php
$file = $_GET['file'];

unlink($file);

header("Location:index.php");


