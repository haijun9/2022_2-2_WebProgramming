<?php
    $date = $_POST['date'];                     // 공연 날짜
    $startingTime = $_POST['startingTime'];     // 공연 시작시간
    $musical = $_POST['musical'];               // 뮤지컬 이름(영어)

    $result=array();   // 현재까지 예매된 좌석들               
    if(is_file("./data/reserved_seat_of_".$musical.".json")) {
        if(filesize("./data/reserved_seat_of_".$musical.".json")!=0) {  
            $myfile=fopen("./data/reserved_seat_of_".$musical.".json", "r");  // 좌석 정보 확인
            while(!feof($myfile)) {
                $line=fgets($myfile);
                $check=json_decode($line,true);
                if($check["date"]===$date && $check["startingTime"]==$startingTime) {   // 해당 날짜와 시작시간 일치 시
                    $reserved_seats = $check["seat"];
                    foreach($reserved_seats as $seat) array_push($result, $seat);   // 현재까지 예매된 좌석들에 추가
                }
            }
            fclose($myfile);
        }
    }

    echo json_encode($result);  // 결과 반환
?>