<?php declare(strict_types=1); ?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="скрипт.js"></script>
    <meta charset="utf-8"/>
    <title>Словарик</title>
    <link type="image/png"  rel="icon" href="favicon-16x16.png">
</head>
<body
style="
background: url(https://phonoteka.org/uploads/posts/2021-06/1624166349_32-phonoteka_org-p-okean-oboi-krasivo-38.jpg)no-repeat center center fixed;
background-size: cover;">




<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = mysqli_connect(
    'localhost',
    'root',
    '',
    'mytest'
);

if(isset($_POST['title'])) {
    $title = $_POST['title'];
}
else {
    $title = 0;
}
mysqli_set_charset(
    $mysqli,
    "utf8"
);

$result = mysqli_query(
    $mysqli, 
    "SELECT * FROM `mytest` WHERE title = '$title'"
);

//echo $result;
//if ($row = mysqli_fetch_assoc($result)) {
    //$content=$row['content']; 
    $row = mysqli_fetch_assoc($result);
    if (preg_match('/ /', $title)) {
        $title = str_replace(" ","_",$title);
    }

    if (!$row) 
    {
        @$html = file_get_contents('https://ru.wikipedia.org/wiki/'.$title);

        if($html === false) { ?>
<div class="seredina">
    <div class="bolshe2"><?php
        exit("По запросу &#171;$title&#187; ничего не найдено. Убедитесь, что правильно написали слово.</div> <form action='slovaric.html'>
        <input type='submit' class='perety' value='Перейти на главную страницу.'></form>
     </div>"); ?>
    <?php 
          } 

        $dom = new DomDocument();
        @$dom->loadHTML($html);
        
        $p = $dom->getElementsByTagName('p')->item(0)->nodeValue; 
        ?>
        <div class="seredina">
        <div class="square">
        <?php 
        $p = preg_replace("/\([^)]+\)/","",$p);
        $p = preg_replace("/\[[^\]]*\]/", '', $p);
        print_r($p); 
        ?></br> </br>
        Взято с сайта: <a style="color: #800080" href="<?php echo 'https://ru.wikipedia.org/wiki/'.$title ?>"><?php echo 'https://ru.wikipedia.org/wiki/'.$title ?> </a></div> <form action='slovaric.html'>
        <input type='submit' class='perety' value='Перейти на главную страницу.'></form>
</div>
    <?php 
    }

    elseif ($row)
    { 
        $content=$row['content'];
        $kol=$row['kol']; 
        $otzivi=$row['otzivi']?>
<div class="seredina">
<div class="square">
    <?php echo $content; ?> </br>
    </br>
    Оцените определение:<form method="post" action="http://localhost/проект/update_otziv.php" >
        <div class="rating-area">
        <input type="radio" id="star-5" name="rating" value="5">
        <label for="star-5" title="Оценка «5»"></label>	
        <input type="radio" id="star-4" name="rating" value="4">
        <label for="star-4" title="Оценка «4»"></label>    
        <input type="radio" id="star-3" name="rating" value="3">
        <label for="star-3" title="Оценка «3»"></label>  
        <input type="radio" id="star-2" name="rating" value="2">
        <label for="star-2" title="Оценка «2»"></label>    
        <input type="radio" id="star-1" name="rating" value="1">
        <label for="star-1" title="Оценка «1»"></label>
        
    </div>
    <input type="hidden" value="<?php echo $content;  ?>" name="content2" >
    <input type="submit" name="button_id3" value="Отправить"> Оценили: <?php 
    if ($kol==0) {
        echo 'Пока никто не оценил';
    }
    else {
    echo $kol; 
    ?> </br>
    Общий рейтинг: <?php echo round($otzivi/$kol, 2); } ?>
    </form></div>
    <form action="slovaric.html">
<input type="submit" class="perety" value="Перейти на главную страницу."></form>
 </div>
        <?php }
        ?> 

</body>
</html>