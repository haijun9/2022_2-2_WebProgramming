<?php
    $id=$_POST["id"];   // ID
    $pwd=$_POST["pwd"]; // password
    
    $isExist = false;   // 로그인 실패인 경우
    if(is_file("./data/person.json")) {
        if(filesize("./data/person.json")!=0) {
            $myfile=fopen("./data/person.json", "r");   // person.json 확인
            while(!feof($myfile)) {                 
                $line=fgets($myfile);               
                $check=json_decode($line,true);     
                if($check["id"]===$id && $check["Password"]===$pwd) {     // 일치하는 id와 pwd 존재 시
                    session_start();                                        // 세션 시작
                    $_SESSION['Name'] = $check["Name"];                     // 세션 Name, 이용자 이름 할당
                    $isExist=true;                                          // 로그인 성공
                    break;
                }
            }
            fclose($myfile);
        }
    }

    // 결과 반환
    if($isExist) echo json_encode(array('result'=>$isExist, 'name'=>$_SESSION['Name']),JSON_UNESCAPED_UNICODE);
    else echo json_encode(array('result'=>$isExist));
?>