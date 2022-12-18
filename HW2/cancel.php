<?php
    session_start();    // 세션 시작

    $id = $_POST['id']; // 예약 번호

    $index=0;           // 회원 파일 줄 수
    $modified;
    $file=fopen("./data/".$_SESSION['id'].".json", "r");    // 회원 파일 확인
    while(!feof($file)) {
        $line=fgets($file);
        $modified[$index++]=$line;  // 일단 전부 읽어와 저장
    }
    fclose($file);
    
    $s_id; $reserve_seat;
    $file=fopen("./data/".$_SESSION['id'].".json", "w");    // 회원 파일 다시 쓰기
    for($i=0; $i<$index; $i++) {
        $check=json_decode($modified[$i],true);
        if($check['id']===$id) {                            // 예약 번호와 취소할 번호가 일치할 경우
            $s_id = $check['s_id'];                         // 스크린 ID 따로 저장
            $reserve_seat = $check['reserve_num'];          // 예매 수 따로 저장
        } else fwrite($file, $modified[$i]);                // 일치하지 않은 경우 다시 write
    }
    fclose($file);

    $index=0;
    $file=fopen("./data/screening.json", "r");              // screening.json 확인
    while(!feof($file)) {
        $line=fgets($file);
        $modified[$index++] = $line;    // 일단 전부 읽어와 저장
    }
    fclose($file);
    
    $file=fopen("./data/screening.json", "w");              // screening.json 다시 쓰기
    for($i=0; $i<$index; $i++) {
        $check=json_decode($modified[$i],true);
        if($check['id']===$s_id) {      // 스크린 ID가 일치할 경우
            $modify = json_encode(array("id"=>$check['id'], "date"=>$check['date'], 
                "movie_id"=>$check['movie_id'], "screening_id"=>$check['screening_id'], 
                "reserve_seat"=>(int)$check['reserve_seat']-(int)$reserve_seat), JSON_UNESCAPED_UNICODE);
            fwrite($file, $modify);     // 예매 취소되는 인원만큼 복구
            if($i != $index-1) fwrite($file, "\n");
        } else fwrite($file, $modified[$i]);    // 일치하지 않는 경우 다시 write
    }
    fclose($file);
?>