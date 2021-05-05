<?php

$dir = "../test";
$item_list= scandir($dir);
echo '<pre>';
foreach($item_list as $item){
    echo "<br><a href=read.php?file=$item><b>$item</b></a>" .
        (is_file("$dir/$item") ?
            " (<a href=rename.php?file=$item&dir=$dir>Rename</a>, <a href=edit.php?dir=$dir&file=$item>Edit</a> or <a href=delete.php?file=$item>Delete</a>)" : '') .
         "<br>";
}
echo '<br><a href="../">На головну</a></pre>';