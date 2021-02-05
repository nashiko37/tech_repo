<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_1-26</title>
    </head>
    <body>
       <?php
       $str = "Hello World2" . PHP_EOL;
       $filename = "mission_1-24.txt";
       $fp = fopen($filename, "a");
       fwrite($fp, $str);
       fclose($fp);
       echo "書き込み成功!<br>";
       
       if(file_exists($filename)){
           $lines = file($filename, 
           FILE_IGNORE_NEW_LINES);
           foreach($lines as $line){
               echo $line . " ";
           }
       }
       ?>
    </body>
</html>