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
    $mysql['url1'] = $_POST['url1'];
    $mysql['url2'] = $_POST['url2'];
    $mysql['title1'] = $_POST['title1'];
    $mysql['title2'] = $_POST['title2'];
    $mysql['img1'] = $_POST['img1'];
    $mysql['img2'] = $_POST['img2'];

    
    #The two urls handed to us might not be in the bvid table because the arrangement is brand new.
    #and if so, that means we need to insert it.

    $sql = "select url1 from bvid " . 
           "where url1 = '" . $mysql['url1'] . "' and url2 = '" . $mysql['url1'] . "';";

    $res = mysqli_query($link, $sql);

    if (!$res) {
      echo "DB Error, could not query the database\n";
      echo 'MySQL Error: ' . mysqli_error();
      exit();
    }
    //$result = mysqli_query($link, $sql);
    // Get the result of query named cnt
    //$question_count = mysqli_result($result, 0);
    //print("question_count: '" . $question_count. "'");

    $result_set_to_get_count = mysqli_query($link, $sql);
    $question_count = mysqli_num_rows($result_set_to_get_count);
    //print("question_count: '" . $question_count. "'");

    if ($question_count > 0){
        //$sql = "update bvid set votes = votes+1 where 1=1";
        $sql = "update bvid set votes = votes+1 " .
               "where url1 = '" . $mysql['url1'] . "' and url2 = '" . $mysql['url2'] . "';";
    
        mysqli_query($link, $sql);
    }
    else{
        $sql = "insert into bvid values ( " . 
               "'" . $mysql['title1'] . "', " .
               "'" . $mysql['url1'] . "', " .
               "'" . $mysql['img1'] . "', " .
               "'" . $mysql['title2'] . "', " .
               "'" . $mysql['url2'] . ", " .
               "'" . $mysql['img2'] . "', 1); ";
    
        mysqli_query($link, $sql);
    
    }

    #when done go back to index.php

    echo "<script type='text/javascript'> document.location = 'index.php';</script>";
?>


