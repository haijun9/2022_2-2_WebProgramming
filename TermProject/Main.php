<?php 
    session_start(); // 세션 시작
    if(!isset($_SESSION['Name'])) {echo '<script>location.href="./Main.html"</script>';} // 회원 정보 없을 시 Main-로그인으로 이동
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
        <link rel="stylesheet" href="./main.css">
        <title>Main Page</title>
    </head>
    <body>
        <header id="banner" class="container">  <!--화면 상단 배너(로그아웃 상태)-->
            <h1 id="main">WP Ticket</h1>
            <nav id="choice">
                <span><button id="logout">로그아웃</button></span> /    <!--로그아웃 버튼-->
                <span><button id="ticketmanage">예매확인</button></span>   <!--예매확인 버튼-->
            </nav>
        </header>

        <div class="slide slide_wrap container">    <!--공연 소개 슬라이드-->
            <div class="slide_item item1">          <!--슬라이드 내용 1-->
                <img src="./img/deathnote.jfif" alt="deathnote">
            </div>
            <div class="slide_item item2">          <!--슬라이드 내용 2-->
                <img src="./img/jejuschrist.jfif" alt="jejuschrist">    
            </div>
            <div class="slide_item item3">          <!--슬라이드 내용 3-->
                <img src="./img/kinkyboots.jfif" alt="kinkyboots">
            </div>
            <div class="slide_item item4">          <!--슬라이드 내용 4-->
                <img src="./img/laughman.jfif" alt="laughman">
            </div>
            <div class="slide_item item5">          <!--슬라이드 내용 5-->
                <img src="./img/sweeney.jfif" alt="sweeney">
            </div>
            <div class="slide_prev_button slide_button">◀</div>     <!--왼쪽 슬라이드 페이지 이동-->
            <div class="slide_next_button slide_button">▶</div>     <!--오른쪽 슬라이드 페이지 이동-->
            <ul class="slide_pagination"></ul>                       <!--페이지네이션 버튼-->
        </div>
        <br>

        <div class="container">                 <!--정렬 버튼-->
            <nav class="Right">                 <!--버튼 정렬-->
                <button id="title">제목순</button>      <!--제목순 정렬 버튼-->
                <button id="date">기간순</button>       <!--기간순 정렬 버튼-->
                <button id="popu">인기순</button>       <!--인기순 정렬 버튼-->
            </nav>
        </div>
        <br><br><br>

        <div class="container">    <!--정렬 버튼과 동기화 + 공연 소개(8작품)-->
            <div class="row introduction" id="introduction">    <!--공연 소개 내역-->
                <div class="col-lg-3 2022-04-01" id="데스노트">  <!--데스노트-->
                    <form action="./TicketBooking.php" method="post" onclick="this.submit();">
                        <input type="hidden" name="musical" value="deathnote">
                        <img src="./img/deathnote.jfif" alt="deathnote" class="poster"> <br>
                        <b>데스노트</b>
                        <br>
                        2022.04.01 ~ 2022.06.26
                    </form>
                </div>
                <div class="col-lg-3 2022-11-10" id="지저스">   <!--지저스 크라이스트 수퍼스타-->
                    <form action="./TicketBooking.php" method="post" onclick="this.submit();">
                        <input type="hidden" name="musical" value="jejuschrist">
                        <img src="./img/jejuschrist.jfif" alt="jejuschrist" class="poster"> <br>
                        <b>지저스 크라이스트 슈퍼스타</b>
                        <br>
                        2022.11.10 ~ 2023.01.15
                    </form>
                </div>
                <div class="col-lg-3 2022-07-20" id="킹키">     <!--킹키부츠-->
                    <form action="./TicketBooking.php" method="post" onclick="this.submit();">
                        <input type="hidden" name="musical" value="kinkyboots">
                        <img src="./img/kinkyboots.jfif" alt="kinkyboots" class="poster"> <br>
                        <b>킹키 부츠</b>
                        <br>
                        2022.07.20 ~ 2022.10.23
                    </form>
                </div>
                <div class="col-lg-3 2022-06-10" id="웃는">     <!--웃는 남자-->
                    <form action="./TicketBooking.php" method="post" onclick="this.submit();">
                        <input type="hidden" name="musical" value="laughman">
                        <img src="./img/laughman.jfif" alt="laughman" class="poster"> <br>
                        <b>웃는 남자</b>
                        <br>
                        2022.06.10 ~ 2022.08.22
                    </form>
                </div>

                <div class="col-lg-3 2022-12-01" id="스위니">   <!--스위니 토드-->
                    <form action="./TicketBooking.php" method="post" onclick="this.submit();">
                        <input type="hidden" name="musical" value="sweeney">
                        <img src="./img/sweeney.jfif" alt="sweeney" class="poster"> <br>
                        <b>스위니 토드</b>
                        <br>
                        2022.12.01 ~ 2023.03.05
                    </form>
                </div>
                <div class="col-lg-3 2022-06-10" id="빨래">     <!--빨래-->
                    <form action="./TicketBooking.php" method="post" onclick="this.submit();">
                        <input type="hidden" name="musical" value="bbalae">
                        <img src="./img/bbalae.jfif" alt="bbalae" class="poster"> <br>
                        <b>빨래</b>
                        <br>
                        2022.06.10 ~ 2023.01.29
                    </form>
                </div>
                <div class="col-lg-3 2021-05-18" id="드라큘라">     <!--드라큘라-->
                    <form action="./TicketBooking.php" method="post" onclick="this.submit();">
                        <input type="hidden" name="musical" value="dracula">
                        <img src="./img/dracula.jfif" alt="dracula" class="poster"> <br>
                        <b>드라큘라</b>
                        <br>
                        2021.05.18 ~ 2021.08.01
                    </form>
                </div>
                <div class="col-lg-3 2021-10-19" id="지킬">         <!--지킬 앤 하이드-->
                    <form action="./TicketBooking.php" method="post" onclick="this.submit();">
                        <input type="hidden" name="musical" value="jekyll">
                        <img src="./img/jekyll.jfif" alt="jekyll" class="poster"> <br>
                        <b>지킬 앤 하이드</b>
                        <br>
                        2021.10.19 ~ 2022.05.08
                    </form>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="./main_logout.js"></script>
    </body>
</html>