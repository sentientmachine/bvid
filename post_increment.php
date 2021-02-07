<?php
    $dbhost = 'localhost'; $dbuser = ''; $dbpass = '';
    $lines_array = file("/home1/machines/pw");
    foreach($lines_array as $line) { $dbpass = trim($line); }
    $lines_array = file("/home1/machines/un");
    foreach($lines_array as $line) { $dbuser = trim($line); }

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
    $dbname = 'machines_organizedthought';
    if (!$link = mysqli_connect($dbhost, $dbuser, $dbpass)) {
      echo 'Could not connect to mysql';
      exit;
    }
    if (!mysqli_select_db($link, $dbname)) {
      echo 'Could not select database, big problem'; exit;
    }



    $mysql = array();
    $mysql['url_text1'] = $_POST['url_text1'];
    $mysql['url_text2'] = $_POST['url_text2'];


    //$sql = "update bvid set votes = votes+1 where 1=1";
    $sql = "update bvid set votes = votes+1 " .
           "where url1 = '" . $mysql['url_text1'] . "' ";
           "and url2 = '" . $mysql['url_text2'] . "';";

    mysqli_query($link, $sql);
    


?>


