<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_2-01</title>
    </head>
    <body>
       <form action = "" method="post">
           <input type="text" name="str"
           value="コメント"
           placeholder = "入力してください">
           <input type="submit" name="submit">
       </form>
       <?php
       if(isset($_POST["str"])){
           $str = $_POST["str"];
           echo $str . "を受け付けしました。<br>";
       }
       ?>
    </body>
</html>