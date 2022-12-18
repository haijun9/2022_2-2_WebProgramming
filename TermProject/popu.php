<?php
    // (뮤지컬, 예매 관객 수) 배열
    $arr = array('bbalae'=>0, 'deathnote'=>0, 'dracula'=>0, 'jejuschrist'=>0, 
    'jekyll'=>0, 'kinkyboots'=>0, 'laughman'=>0, 'sweeney'=>0);

    foreach($arr as $musical => $people) {
        if(is_file("./data/reserved_seat_of_".$musical.".json")){   // 뮤지컬 별 예매 정보 파일 확인
            if(filesize("./data/reserved_seat_of_".$musical.".json")!=0) {  // 크기가 0이 아닐 경우 체크
                $myfile=fopen("./data/reserved_seat_of_".$musical.".json", "r");    
                while(!feof($myfile)) {
                    $line=fgets($myfile);
                    $check=json_decode($line,true);
                    $arr[$musical] = $arr[$musical] + $check['people'];     // 모든 예매 인원 수 종합
                }
                fclose($myfile);
            }
        }
    }
    arsort($arr);           // 많은 인원 수 별로 정렬
    echo json_encode($arr); // 결과 반환
?>