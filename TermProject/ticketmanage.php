<?php
    session_start();        // 세션 시작
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
          crossorigin="anonymous"
        >
        <script
          src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
          integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
          crossorigin="anonymous"
        ></script>
        <link rel="stylesheet" href="./ticketmanage.css">
        <title>Ticket Manage Page</title>
    </head>
    <body>
        <header id="banner" class="container">      <!--화면 상단 배너(로그인 상태)-->
            <h1 id="main">WP Ticket</h1>
            <nav id="choice">
                <span><button id="logout">로그아웃</button></span> /        <!--로그아웃 버튼-->
                <span><button id="ticketmanage">예매확인</button></span>    <!--예매확인 버튼-->
            </nav>
        </header>
        <br><br>

        <table class="container">       <!--예매 내역 목록 창(예시)-->
            <?php
                if(is_file("./data/".$_SESSION['Name'].".json")) {
                    if(filesize("./data/".$_SESSION['Name'].".json")!=0) {
                        $file=fopen("./data/".$_SESSION['Name'].".json", "r");    // 회원 파일 확인
                        while(!feof($file)) {
                            $line=fgets($file);
                            $line=json_decode($line,true);
                            echo '<tr>';
                            echo '<th class="poster"><img src="./img/'.$line['musical'].'.jfif" alt="poster"></th>';        // 뮤지컬 포스터
                            echo '<th class="info">';                                                                       
                            echo '<ul><li> 제목 : '.$line['musical_name'].'</li>';                                          // 뮤지컬 이름(한글)
                            echo '<li> 장소 : '.$line['place'].'</li>';                                                     // 공연 장소
                            echo '<li> 날짜 : '.$line['date'].' '.$line['isFirst'].' '.$line['startingTime'].'</li>';       // 공연 일시
                            echo '<li> 좌석 : '.$line['seat'].' '.$line['people'].'명</li></ul>';                           // 좌석 정보
                            echo '<input type="button" id="'.$line['reserve_no'].'" class="buttons" value="예매 취소">';    // 예매 취소 버튼
                            echo '</tr>';
                        }
                        fclose($file);
                    }
                    else echo "<div class='container'> 현재 예매 목록이 없습니다! </div>";  // 예매 내역이 하나도 없을 경우
                }
                else echo "<div class='container'> 현재 예매 목록이 없습니다! </div>";  // 예매한 경험이 아예 없을 경우
            ?>
        </table>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="./ticketmanage.js"></script>
    </body>
</html>