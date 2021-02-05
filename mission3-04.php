<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_3-04</title>
    </head>
    <body>
        <?php
        //関数
        //投稿番号
       function countNum($filename0){
           if(file_exists($filename0)){
               $num = count(file($filename0))+1;
           }else{
               $num=1;
           }
           return $num;
       }
       //ファイル読み込み&PHPで配列にする
       function readLines($filename){
           if(file_exists($filename)){
               $lines = file($filename, FILE_IGNORE_NEW_LINES);
               return $lines;
           }
       }
       //ファイルの上書き
       function rewrite($fp, $lines, $delNum){
           foreach($lines as $line){
               $words=explode("<>",$line);
               if($words[0]!=$delNum){
                   fwrite($fp, $line.PHP_EOL);
               }
           }
       }
       //追加
       function addText($fp0,$fp,$num,$name,$comment,$date){
           $text = $num."<>".$name."<>".$comment."<>".$date;
           fwrite($fp0,$text.PHP_EOL);
           fwrite($fp,$text . PHP_EOL);
           
       }
       //ファイル生成
       function makeFile($filename0,$filename,$num,$name,$comment,$date){
           $lines=readLines($filename);
           $fp0 =fopen($filename0,"a");
           $fp = fopen($filename, "w");
           rewrite($fp,$lines,-1);
           addText($fp0,$fp,$num, $name, $comment, $date);
           fclose($fp);
       }
       //削除
       function deleteFile($filename, $delNum){
           $lines=readLines($filename);
           $fp = fopen($filename, "w");
           rewrite($fp,$lines,$delNum);
           fclose($fp);
       }
       //編集する行の取り出し
       function selectFile($filename0,$filename, $editNum){
           $lines = readLines($filename0);
           $editWords=explode("<>",$lines[$editNum-1]);
           return $editWords;
       }
       //編集
       function editFile($filename0,$filename,$editNum, $name,$comment,$date){
           $text = $editNum."<>".$name."<>".$comment."<>".$date;
           $lines0 = readLines($filename0);
           $lines = readLines($filename);
           $fp0 = fopen($filename0, "w");
           $fp = fopen($filename,"w");
           
           foreach($lines0 as $line0){
               $words = explode("<>",$line0);
               if($words[0]!=$editNum){
                   fwrite($fp0, $line0.PHP_EOL);
               }else{
                   fwrite($fp0, $text."(編集)".PHP_EOL);
               }
           }
           fclose($fp0);
           
           foreach($lines as $line){
               $words = explode("<>",$line);
               if($words[0]!=$editNum){
                   fwrite($fp, $line.PHP_EOL);
               }else{
                   fwrite($fp, $text.PHP_EOL);
               }
           }
           fclose($fp);
       }
       
       //ファイルの中身をブラウザに表示
       function display($filename){
           $lines=readLines($filename);
           foreach($lines as $line){
               $words=explode("<>",$line);
               foreach($words as $word){
                   echo $word . " ";
               }
               echo "<br>";
           }
       }
        
        ?>
        <?php
        $filename0 = "mission_3-4-0.txt";
        $filename = "mission_3-4-1.txt";
        if(!empty($_POST["editNum"])){
           $editNum = $_POST["editNum"];
           $editWords=selectFile($filename0,$filename, $editNum);
           $editName = $editWords[1];
           $editComment = $editWords[2];
        }else{
           $editNum=-1;
        }
        ?>
        
        <form action = "" method="post">
           お名前 : <input type="text" name="name"
           value = "<?php if($editNum!=-1){echo $editName;} ?>";
           placeholder="名前">
           <br>
           コメント：<input type="text" name="comment"
           value = "<?php if($editNum!=-1){echo $editComment;} ?>";
           placeholder = "コメント">
           <input type="hidden" name="hiddenNum"
           value = "<?php echo $editNum ?>">
           <input type="submit" name="submit">
           <br><br>
           削除番号：<input type="number" name="delNum"
           placeholder = "削除番号">
           <input type="submit" name="削除">
           <br><br>
           編集番号：<input type="number" name="editNum"
           placeholder = "編集番号">
           <input type="submit" name="編集">'
       </form>
       <?php
       
       //*******************************
       //$filename0 = "m4-0.txt";
       //$filename = "m4-1.txt";
       $num=countNum($filename0);
       //削除
       if(!empty($_POST["delNum"])){
           $delNum=$_POST["delNum"];
           deleteFile($filename,$delNum);
       }
       
       if(!empty($_POST["name"]&&$_POST["comment"])){
           //フォームからPOST送信＆受け取り
           $date = date("Y/m/d H:i:s");
           $name = $_POST["name"];
           $comment = $_POST["comment"];
           $hiddenNum = $_POST["hiddenNum"];
           if($hiddenNum==-1){
               makeFile($filename0,$filename,$num,$name,$comment,$date);
           }else{
               editFile($filename0,$filename,$hiddenNum,$name,$comment,$date); 
           }
           
       }
       display($filename);

       ?>
    </body>
</html>