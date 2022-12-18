<?php
    session_start();

    $id = $_POST["id"];             // 선택된 상영관 id
    $people = $_POST["people"];     // 예약 인원 수

    $reserved=true;
    $max=true;

    if(!isset($_SESSION['id'])) $reserved=false;       // 미로그인 시 예약 불가
    else {                                             // 로그인 시 예약 진행
        $index=0;
        $tmp_screening_json;
        $myfile=fopen("./data/screening.json", "r");    // screening.json 확인
        if(filesize("./data/screening.json")!=0) {
            while(!feof($myfile)) {
                $line=fgets($myfile);
                $check=json_decode($line,true);
                if($check["id"]===$id) {    // 스크린 id가 같다면
                    if((int)$check["reserve_seat"] + (int)$people > 20) $max=false; // 수용 인원 초과 시 불가
                    else {                  // 수용 인원 이내일 경우
                        $count=0;           // 예약 번호
                        if(file_exists("./data/".$_SESSION['id'].".json")) {
                            $file=fopen("./data/".$_SESSION['id'].".json", "r"); // 회원 파일 확인
                            while(!feof($file)) {
                                fgets($file);
                                $count++;
                            }
                            fclose($file);
                        }
                        
                        $file=fopen("./data/".$_SESSION['id'].".json", "a+");   // 예매 정보 추가
                        if(filesize("./data/".$_SESSION['id'].".json")!=0) fwrite($file, "\n");
                        $data = json_encode(array("id"=>"u".$count, "movie_id"=>$check["movie_id"], 
                            "s_id"=>$check["id"], "reserve_num"=>$people), JSON_UNESCAPED_UNICODE);
                        fwrite($file, $data);
                        fclose($file);
                    }
                }
                $tmp_screening_json[$index++] = $line;  // 예약하는 상영관 정보 따로 저장 중
            }
            
            if($reserved==true && $max==true) {             // 정상적으로 회원 파일에 예매 정보를 적었다면 (=예매 성공)
                $file=fopen("./data/screening.json", "w");  // screening.json 확인
                for($i=0; $i<$index; $i++) {                // 예매에 따른 인원 변동 수정
                    $check=json_decode($tmp_screening_json[$i],true);
                    if($check["id"]===$id) $check['reserve_seat'] = (int)$check['reserve_seat'] + (int)$people;
                    $check=json_encode($check, JSON_UNESCAPED_UNICODE);
                    fwrite($file, $check);
                    if($i != $index-1) fwrite($file, "\n");
                }
                fclose($file);
            }
        }
        fclose($myfile);   
    }

    echo json_encode(array('result'=>$reserved, 'max'=>$max));
?>