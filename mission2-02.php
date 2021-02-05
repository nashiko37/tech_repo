<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_2-02</title>
    </head>
    <body>
        
       <form action = "" method="post">
           <input type="text" name="str"
           value="コメント"
           required = "required"
           placeholder = "入力してください">
           <input type="submit" name="submit">
       </form>
       <?php
       //フォームからPOST送信＆受け取り
       $str = $_POST["str"];
       echo $str . "を受け付けしました。<br>";
       //テキスト保存
       $filename = "mission_2-2.txt";
       $fp = fopen($filename, "w");
       fwrite($fp,$str . PHP_EOL);
       fclose($fp);
       //条件分岐
       if($str == "完成！"){
           echo "おめでとう！<br>";
        
       }
       
       /*
       if(!empty($_POST["str"])){
           //フォームからPOST送信＆受け取り
           $str = $_POST["str"];
           echo $str . "を受け付けしました。<br>";
           //テキスト保存
           $filename = "mission_2-2.txt";
           $fp = fopen($filename, "w");
           fwrite($fp,$str . PHP_EOL);
           fclose($fp);
           //条件分岐
           if($str == "完成！"){
               echo "おめでとう！<br>";
           }
       }*/
       ?>
    </body>
</html>