<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_1-24</title>
    </head>
    <body>
       <?php
       $str = "Good luck!" . PHP_EOL;
       $filename = "mission_1-24.txt";
       $fp = fopen($filename, "a");
       fwrite($fp,$str);
       fclose($fp);
       echo "書き込み成功!";
       ?>
       
    </body>
</html>