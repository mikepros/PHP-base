<?php

$content='';
$file=$_GET['file'];
$byte_content=fopen($file,'r');

while (!feof($byte_content)) {
    $content.=fread($byte_content,1);
}
echo $content;