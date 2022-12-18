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
            crossorigin="anonymous">
        <link rel="stylesheet" href="./user_reserved.css">
        <title>Movie</title>
    </head>
    <body>
        <span id="identify">        <!-- 회원 정보 -->
            <span id="user"><?php echo $_SESSION['id']?></span> 회원
        </span> <br><br><br><br>

        <table class="container-fluid" id="reserved_list">  <!-- 예약 정보 테이블 -->
            <tr>
                <th>체크</th>
                <th>예약 번호</th>
                <th>영화 제목</th>
                <th>상영 날짜</th>
                <th>상영 장소</th>
                <th>예매 수</th>    
            <tr>
            <?php
                if(!is_file("./data/".$_SESSION['id'].".json")) exit;   // 예약 정보가 없을 경우
                
                $file=fopen("./data/".$_SESSION['id'].".json", "r");    // 회원 파일 확인
                while(!feof($file)) {
                    $line=fgets($file);
                    $line=json_decode($line,true);

                    $movie_name;
                    $tmp_file=fopen("./data/movie.json", "r");          // movie.json 확인
                    while(!feof($tmp_file)) {
                        $check=fgets($tmp_file);
                        $check=json_decode($check,true);
                        if($check['id']===$line['movie_id']) {          // 영화 ID 일치 시
                            $movie_name=$check['movie_name'];           // 영화 제목 저장
                            break;
                        }
                    }
                    fclose($tmp_file);

                    $date; $screening_id;
                    $tmp_file=fopen("./data/screening.json", "r");      // screening.json 확인
                    while(!feof($tmp_file)) {
                        $check=fgets($tmp_file);
                        $check=json_decode($check,true);
                        if($check['id']===$line['s_id']) {              // 스크린 ID 일치 시
                            $date = $check['date'];                     // 상영 날짜 저장
                            $screening_id = $check['screening_id'];     // 상영 장소 저장
                            break;
                        }
                    }
                    fclose($tmp_file);

                    echo '<tr>';
                    echo '<td><input type="checkbox" class="reserved" name="reserved" value="'.$line['id'].'"</td>';        // 체크
                    echo '<td>'.$line['id'].'</td>';                                                                        // 예약 번호
                    echo '<td>'.$movie_name.'</td>';                                                                        // 영화 제목
                    echo '<td>'.$date.'</td>';                                                                              // 상영 날짜
                    echo '<td>'.$screening_id.'</td>';                                                                      // 상영 장소
                    echo '<td>'.$line['reserve_num'].'</td>';                                                               // 예매 수
                    echo '</tr>';
                }
                fclose($file);
            ?>
        </table> <br><br>
        <input type="button" value="취소하기" id="cancel">  <!-- 예매 취소 버튼 -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="user_reservedJS.js"></script>
    </body>
</html>