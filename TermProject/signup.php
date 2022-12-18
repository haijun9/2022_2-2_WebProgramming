<?php
    $name=$_POST["name"];   // 가입자 이름
    $id=$_POST["id"];       // ID
    $pwd=$_POST["pwd"];     // password

    $isOk = true;           // 가입 가능 시 true
    if(is_file("./data/person.json")) {             // person.json 파일 존재 확인
        if(filesize("./data/person.json")!=0) {
            $myfile=fopen("./data/person.json", "r");
            while(!feof($myfile)) {
                $line=fgets($myfile);
                $check=json_decode($line,true);
                if($check['id']===$id) {                // 중복 ID 존재 시
                    $isOk=false;                        // 가입 불가
                    break;
                }
            }
            fclose($myfile);
        }
    }
   
    if($isOk) {          // 회원가입 성공 시
        $myfile=fopen("./data/person.json", "a+");
        if(filesize("./data/person.json")!=0) fwrite($myfile, "\n");
        $data = json_encode(array("Name"=>$name, "id"=>$id, "Password"=>$pwd), JSON_UNESCAPED_UNICODE); 
        fwrite($myfile, $data); // 회원 정보 기입
        fclose($myfile);    
    }
    echo json_encode(array('result'=>$isOk)); // 결과 반환
?>