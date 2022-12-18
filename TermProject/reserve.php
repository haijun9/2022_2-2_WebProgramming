<?php
    session_start();    // 세션 시작

    $musical = $_POST['musical'];           // 뮤지컬 이름(영문)
    $date = $_POST['date'];                 // 공연 날짜
    $time = $_POST['time'];                 // 부(시간)
    $startingTime = $_POST['startingTime']; // 공연 시작 시간
    $seat = $_POST['seat'];                 // 선택한 좌석
    $people = $_POST['people'];             // 인원 수
    $musical_name;                          // 뮤지컬 이름(한글)
    $place;                                 // 공연 장소
    $isFirst;                               // 1부 or 2부
          
    $reserve_Num="No.0";   // 예매 구분 id
    if(is_file("./data/".$_SESSION['Name'].".json")) {
        if(filesize("./data/".$_SESSION['Name'].".json")!=0) {
            $count=0;
            $reserved_numbers; // 예매 번호 전부
            $file=fopen("./data/".$_SESSION['Name'].".json", "r");  // 이용자 예매 내역 확인    
            while(!feof($file)) {
                $line=fgets($file);
                $check=json_decode($line,true);
                $reserved_numbers[$count++]=$check['reserve_no']; // 예매 번호 저장
            }
            fclose($file);

            sort($reserved_numbers);    // 예매 번호 오름차순 정렬
            for($i=0; $i<=$count; $i++) {
                $reserve_Num="No.".$i;                          // 번호 갱신
                if("No.".$i !== $reserved_numbers[$i]) break;   // 비어있는 번호가 있다면 이용
            }
        }
    }

    switch($musical) {  // 뮤지컬 이름(영문)에 따라 뮤지컬 이름(한글), 공연 장소 설정
        case "deathnote":
            $musical_name = "데스노트"; $place = "충무아트센터 대극장"; break;
        case "bbalae":
            $musical_name = "빨래"; $place = "유니플렉스 2관"; break;
        case "dracula":
            $musical_name = "드라큘라"; $place = "블루스퀘어 신한카드홀"; break;
        case "jejuschrist":
            $musical_name = "지저스 크라이스트 수퍼스타"; $place = "광림교회 BBCH홀"; break;
        case "jekyll":
            $musical_name = "지킬 앤 하이드"; $place = "샤롯데씨어터"; break;
        case "kinkyboots":
            $musical_name = "킹키부츠"; $place = "충무아트센터 대극장"; break;
        case "laughman":
            $musical_name = "웃는 남자"; $place = "세종문화회관 대극장"; break;
        case "sweeney":
            $musical_name = "스위니토드"; $place = "샤롯데씨어터"; break;
    }

    if($time==="first") $isFirst="1부"; // 1부 or 2부 구분
    else $isFirst="2부";

    $myfile=fopen("./data/".$_SESSION['Name'].".json", "a+");   // 회원 예매 정보에 추가
    if(filesize("./data/".$_SESSION['Name'].".json")!=0) fwrite($myfile, "\n");
    $data = json_encode(array(
      "reserve_no"=>$reserve_Num, "musical"=>$musical, "musical_name"=>$musical_name, "place"=>$place, "date"=>$date, 
      "isFirst"=>$isFirst, "startingTime"=>$startingTime, "seat"=>implode(",", $seat), "people"=>$people), JSON_UNESCAPED_UNICODE);
    fwrite($myfile, $data);
    fclose($myfile);

    $myfile=fopen("./data/reserved_seat_of_".$musical.".json", "a+");   // 공연 예매 정보에 추가
    if(filesize("./data/reserved_seat_of_".$musical.".json")!=0) fwrite($myfile, "\n");
    $data = json_encode(array("date"=>$date, "startingTime"=>$startingTime, "seat"=>$seat, "people"=>$people), JSON_UNESCAPED_UNICODE);
    fwrite($myfile, $data);
    fclose($myfile);
?>