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
  
    #TODO: confirm that the URL is not already submitted
    #TODO: do a basic sniff test to see if the youtube url is valid.
    #TODO: fetch the youtube image and download it into the /images/ folder
    #TODO: Pick another URL from our list (randomly at first, later one with bias toward the top)
    #TODO: Insert it into the database then refresh the page.



    #The two urls handed to us might not be in the bvid table because the arrangement is brand new.
    #and if so, that means we need to insert it.

    //$sql = "select url1 from bvid " . 
    //       "where url1 = '" . $mysql['url_text1'] . "' and url2 = '" . $mysql['url_text2'] . "';";
    //
    //$res = mysqli_query($link, $sql);
    //
    //if (!$res) {
    //  echo "DB Error, could not query the database\n";
    //  echo 'MySQL Error: ' . mysqli_error();
    //  exit();
    //}
    ////$result = mysqli_query($link, $sql);
    //// Get the result of query named cnt
    ////$question_count = mysqli_result($result, 0);
    ////print("question_count: '" . $question_count. "'");
    //
    //$result_set_to_get_count = mysqli_query($link, $sql);
    //$question_count = mysqli_num_rows($result_set_to_get_count);
    ////print("question_count: '" . $question_count. "'");
    //
    //if ($question_count > 0){
    //    //$sql = "update bvid set votes = votes+1 where 1=1";
    //    $sql = "update bvid set votes = votes+1 " .
    //           "where url1 = '" . $mysql['url_text1'] . "' and url2 = '" . $mysql['url_text2'] . "';";
    //
    //    mysqli_query($link, $sql);
    //}
    //else{
    //    #TODO:
    //
    //    $sql = "insert into bvid values ( " . 
    //           "'The Living Universe - Documentary about Consciousness and Reality | Waking Cosmos', " .
    //           "'https://www.youtube.com/watch?v=WSDnRbxGlFw', " .
    //           "'universe_is_alive.jpg', " .
    //           "'Fransis Derelle & CRaymak - Ember (feat. HVDES)', " .
    //           "'https://www.youtube.com/watch?v=HD4WthE414k', " .
    //           "'ember.jpg', 1); ";
    //
    //    //$sql = "insert into bvid  " .
    //    //       "where url1 = '" . $mysql['url_text1'] . "' and url2 = '" . $mysql['url_text2'] . "';";
    //
    //    mysqli_query($link, $sql);
    //
    //}

    #when done go back to index.php
    echo "<script type='text/javascript'> document.location = 'index.php';</script>";
?>


