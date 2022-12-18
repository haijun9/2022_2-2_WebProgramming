<?php
    session_start();    // 세션 시작

    $reserve_no = $_POST['reserve_no']; // 예매 번호

    $index=0;           
    $reserved_info; // 예매 내역 전부
    if(is_file("./data/".$_SESSION['Name'].".json")) {
        if(filesize("./data/".$_SESSION['Name'].".json")!=0) {
            $file=fopen("./data/".$_SESSION['Name'].".json", "r");  // 이용자 예매 내역 확인    
            while(!feof($file)) {
                $line=fgets($file);
                $reserved_info[$index++]=$line; // 예매 내역 저장
            }
            fclose($file);
        }
    }

    $musical; $date; $startingTime; $seat; $people;         // 뮤지컬 이름(영문), 공연 날짜, 시작 시간, 좌석, 인원 수
    if(is_file("./data/".$_SESSION['Name'].".json")) {
        if(filesize("./data/".$_SESSION['Name'].".json")!=0) {
            $file=fopen("./data/".$_SESSION['Name'].".json", "w");   
            for($i=0; $i<$index; $i++) {
                $check=json_decode($reserved_info[$i],true);
                if($check['reserve_no']===$reserve_no) {            // 취소하려는 공연과 일치하면
                    $musical = $check['musical'];                         
                    $date = $check['date'];
                    $startingTime = $check['startingTime'];         // 정보를 따로 저장만 하고 쓰지는 않는다
                    $seat = $check['seat'];
                    $people = $check['people'];       
                } else fwrite($file, $reserved_info[$i]);           // 일치하지 않는 경우 파일에 쓰기  
            }
            fclose($file);
        }
    }

    $index=0;           
    $reserved_seat_of_musical;      // 예매 좌석 정보
    if(is_file("./data/reserved_seat_of_".$musical.".json")) {
        if(filesize("./data/reserved_seat_of_".$musical.".json")!=0) {
            $file=fopen("./data/reserved_seat_of_".$musical.".json", "r"); // 해당 공연 좌석 정보 확인   
            while(!feof($file)) {
                $line=fgets($file);
                $reserved_seat_of_musical[$index++]=$line; // 좌석 정보 저장
            }
            fclose($file);
        }
    }

    if(is_file("./data/reserved_seat_of_".$musical.".json")) {
        if(filesize("./data/reserved_seat_of_".$musical.".json")!=0) {
            $file=fopen("./data/reserved_seat_of_".$musical.".json", "w");            
            for($i=0; $i<$index; $i++) {
                $check=json_decode($reserved_seat_of_musical[$i],true);
                if($check['date']===$date && $check['startingTime']===$startingTime 
                    && implode(',',$check['seat'])===$seat && $check['people']===$people) continue; // 취소하려는 공연과 일치하면 건너뛰기
                else fwrite($file, $reserved_seat_of_musical[$i]);    // 일치하지 않는 경우 파일에 쓰기
            }
            fclose($file);
        }
    }
?>