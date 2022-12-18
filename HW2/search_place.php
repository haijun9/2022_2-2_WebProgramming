<?php
    $id = $_POST["id"];                             // 선택된 영화 ID

    $path="./data";
    if(!is_dir($path)) mkdir($path, 0777);          // data 폴더 없다면 생성

    $result=array();                                // 결과 배열
    $myfile=fopen("./data/screening.json", "r");    // screening.json 확인
    if(filesize("./data/screening.json")!=0) {
        while(!feof($myfile)) {
            $line=fgets($myfile);
            $check=json_decode($line,true);
            if($check["movie_id"]===$id) array_push($result, $check);   // id가 일치하면 배열 저장
        }
    }
    fclose($myfile);

    echo json_encode($result);
?>