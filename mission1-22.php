<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_22</title>
    </head>
    <body>
       <?php
       $items=array("キャベツ","レタス",
       "ハクサイ","ホウレンソウ","コマツナ");
       for($i=0; $i<5; $i++){
           echo $items[$i] . "<br>";
       }
       ?>
    </body>
</html>