<?php
    $id=$_POST["id"];   // ID
    $pwd=$_POST["pwd"]; // password

    $path="./data";
    if(!is_dir($path)) mkdir($path, 0777);  // data 폴더가 없다면 생성

    $isExist = false;   // 로그인 실패인 경우
    $myfile=fopen("./data/person.json", "r");   // person.json 확인
    if(filesize("./data/person.json")!=0) {
        while(!feof($myfile)) {
            $line=fgets($myfile);
            $check=json_decode($line,true);
            if($check["Name"]===$id && $check["Password"]===$pwd) {     // 일치하는 id와 pwd 존재
                session_start();                                        // 세션 시작
                $_SESSION['id'] = $id;                                  // 세션 id 할당
                $isExist=true;                                          // 로그인 성공
                break;
            }
        }
    }
    fclose($myfile);

    echo json_encode(array('result'=>$isExist, 'id'=>$id));
?>