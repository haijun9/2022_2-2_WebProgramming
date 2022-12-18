<?php
    $info = $_POST["info"];                     // 검색 정보

    $path="./data";
    if(!is_dir($path)) mkdir($path, 0777);      // data 폴더 없으면 생성

    $result=array();                            // 결과 배열
    $myfile=fopen("./data/movie.json", "r");    // movie.json 확인
    if(filesize("./data/movie.json")!=0) {
        while(!feof($myfile)) {
            $line=fgets($myfile);               // 한 줄 씩 확인
            $check=json_decode($line,true);
            $matched=false;
            if(strpos($check["movie_name"], $info)!==false || strpos($check["director"], $info)!==false) {
                $matched=true;  // 영화 제목이나 감독 이름이 일치하는 경우
            } else {
                foreach($check["actors"] as $x) if(strpos($x, $info)!==false) $matched=true;    // 출연자 이름이 일치하는 경우
            }
            if($matched) array_push($result, $check);   // 일치한다면 결과에 저장
        }
    }
    fclose($myfile);

    echo json_encode($result);
?>