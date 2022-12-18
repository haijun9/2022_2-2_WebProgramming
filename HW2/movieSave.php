<?php
  $title=$_POST["title"];         // 제목
  $genre=$_POST["genre"];         // 장르
  $director=$_POST["director"];   // 감독
  $actor=$_POST["actor"];         // 배우
  
  $path="./data";
  if(!is_dir($path)) mkdir($path, 0777);  // data 폴더 없을 시 생성

  $path="./uploads";
  $tmpFile=$_FILES["file"]["tmp_name"];
  $check=explode("/", $_FILES["file"]["type"]);
  $uploadOk=false;
  switch($check[1]) {         // 확장자 확인
    case 'jpg': case 'png': case 'gif': case 'jpeg':    // 허용
      $uploadOk=true;
      break;
    default:      // 거부
      echo "jpg, png, gif, jpeg 확장자만을 가지는 이미지 파일만 저장 가능합니다.";
      exit;
      break;
  }
  if($uploadOk) {   // 포스터 파일 저장 가능
    if(!is_dir($path)) mkdir($path, 0777);
    $uploaded=$path."/".$_FILES['file']['name'];
    copy($tmpFile, $uploaded);
    chmod($uploaded, 0777);
  } else {      // 포스터 파일 저장 불가능
    echo "jpg, png, gif, jpeg 확장자만을 가지는 이미지 파일만 저장 가능합니다.";
    exit;
  }

  $count=0;                                 // movie.json 줄 수
  if(is_file("./data/movie.json")) {        // movie.json 파일 존재 확인
    $tmp=fopen("./data/movie.json", "r");
    while(!feof($tmp)) {
        fgets($tmp);
        $count++;
    }
    fclose($tmp);
  }
  $movie_count="m".$count;                  // 영화 구분 id

  $myfile=fopen("./data/movie.json", "a+");   // movie.json에 데이터 저장
  if(filesize("./data/movie.json")!=0) fwrite($myfile, "\n");
  $data = json_encode(array(
    "id"=>$movie_count, "movie_name"=>$title, "genre"=>$genre, "director"=>$director, "actors"=> $actor,
    "file_name"=>$_FILES["file"]["name"]), JSON_UNESCAPED_UNICODE);
  fwrite($myfile, $data);
  fclose($myfile);

  $count=0;                                   // screening.json 줄 수
  if(is_file("./data/screening.json")) {      // screening.json 파일 존재 확인
    $tmp=fopen("./data/screening.json", "r");
    while(!feof($tmp)) {
        fgets($tmp);
        $count++;
    }
    fclose($tmp);
  }
  $screen_count="r".$count;         // 상영 정보 구분 id

  $place=$_POST["place"];
  $myfile=fopen("./data/screening.json", "a+");   // screening.json에 데이터 저장
  if(filesize("./data/screening.json")!=0) fwrite($myfile, "\n");
  for($i=0; $i<count($place); $i++) {
    $split=explode(",", $place[$i]);
    $data = json_encode(array(
        "id"=>$screen_count, "date"=>$split[0], "movie_id"=>$movie_count, "screening_id"=>$split[1], "reserve_seat"=>0,)
        , JSON_UNESCAPED_UNICODE);
    fwrite($myfile, $data);
    $screen_count="r".(++$count);
    if($i != count($place)-1) fwrite($myfile, "\n");
  }
  fclose($myfile);

  echo "저장되었습니다.";
?>