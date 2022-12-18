<?php
    session_start();    // 세션 시작
    if(!isset($_SESSION['Name'])) {     // 로그인 상태가 아닐 경우
        echo "<script>
            alert('로그인 후 이용 가능합니다.');
            location.href='./Main.html';
        </script>";         // 안내 문구 출력
    }
    $musical = $_POST['musical'];   // 예매 하려는 뮤지컬 이름
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
        <link rel="stylesheet" href="./ticketbooking.css">
        <title>Ticket Booking Page</title>
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

        <table class="container">       <!--티켓 예매 메인 창-->
            <tr>
                <td rowspan="2" class="one">     <!--공연 포스터-->
                    <?php echo '<img src="./img/'.$musical.'.jfif" alt="'.$musical.'">' ?>  <!--예매하려는 뮤지컬 포스터-->
                </td>
                <td class="half">
                    <input type="date" id="date"> <br><br>  <!--날짜 선택-->
                    <select name="when" id="when">          <!--부(시간) 선택-->
                        <option value="first">1부</option>
                        <option value="second">2부</option>
                    </select>
                </td>
                <td rowspan="2" class="one">        
                    <p id="stage">Stage</p> <br><br>    <!--좌석 선택-->
                    <div class="seat_Set"></div><br>    <!--좌석 목록-->
                    <p>* 인당 한 번에 최대 2좌석 예매 가능합니다.</p>
                </td>
                <td class="half">   <!--공연 장소-->
                    <?php
                        switch($musical) {  // 뮤지컬에 따라 안내
                            case "bbalae": 
                                echo '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3161.8930080534624!2d127.00113014086038!3d37.58113702340629!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca32c15a304f1%3A0x9b3d60b3a0b48cc1!2z7Jyg64uI7ZSM66CJ7Iqk!5e0!3m2!1sko!2skr!4v1669449101437!5m2!1sko!2skr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                                break;
                            case "deathnote": case "kinkyboots":
                                echo '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3162.5351705583817!2d127.01481310000001!3d37.5660139!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca33ee939aa3d%3A0x89bed05fbc588c8b!2z7Lap66y07JWE7Yq47IS87YSw!5e0!3m2!1sko!2skr!4v1669449679235!5m2!1sko!2skr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                                break;
                            case "dracula":
                                echo '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3163.6017129572538!2d126.99987654085905!3d37.540885025714005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca3ae767cc747%3A0xf39a61c7a1ca7171!2z67iU66Oo7Iqk7YCY7Ja0!5e0!3m2!1sko!2skr!4v1669450191628!5m2!1sko!2skr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                                break;
                            case "jejuschrist":
                                echo '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3164.3272647029466!2d127.0204921897237!3d37.5237820545214!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca3930abb452f%3A0xc0116ca4cceced36!2z6rSR66a87JWE7Yq47IS87YSwIEJCQ-2ZgA!5e0!3m2!1sko!2skr!4v1669450258467!5m2!1sko!2skr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                                break;
                            case "laughman":
                                echo '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3162.2726093492224!2d126.97331212647828!3d37.57219792380239!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca2eb4d3089f9%3A0xdc83747259b1898d!2z7IS47KKF66y47ZmU7ZqM6rSA!5e0!3m2!1sko!2skr!4v1669450425215!5m2!1sko!2skr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                                break;
                            case "jekyll": case "sweeney":
                                echo '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3164.8815428368866!2d127.09727447647612!3d37.5107119273263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca5a72092e9d5%3A0xa7654fec3c9224d8!2z7IOk66Gv642w7JSo7Ja07YSw!5e0!3m2!1sko!2skr!4v1669450313363!5m2!1sko!2skr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                                break;
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td class="half" id="casting"></td>     <!--캐스팅 목록-->
                <td class="half">       <!--예매 확인 or 취소-->
                    <div><input type="button" id="ok" value="예매"> <input type="button" id="cancel" value="취소"></div>
                </td>
            </tr>
        </table>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="./ticketbooking.js"></script>
    </body>
</html>