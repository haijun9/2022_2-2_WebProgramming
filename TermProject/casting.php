<?php
    $musical = $_POST['musical'];   // 뮤지컬 이름 (영문)
    $date = $_POST['date'];         // 공연 날짜                   
    $time = $_POST['time'];         // 부(시간)

    $cast=array();                                  // 캐스팅 목록
    if(is_file("./data/".$musical.".json")) {
        if(filesize("./data/".$musical.".json")!=0) {   // 해당 공연 캐스팅 목록 확인
            $myfile=fopen("./data/".$musical.".json", "r");    
            while(!feof($myfile)) {
                $line=fgets($myfile);
                $check=json_decode($line,true);
                if($check["date"]==$date) {     // 공연 날짜 일치할 경우
                    if($time==='first') array_push($cast, $check);  // 1부면 첫 번째 정보 반환
                    else $time = 'first';       // 2부면 다음 줄 정보로 
                }
            }
            fclose($myfile);
        }
    }
    
    echo json_encode($cast);    // 결과 반환
?>