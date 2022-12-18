<?php
    $id=$_POST["id"];   // ID
    $pwd=$_POST["pwd"]; // password

    $path="./data";
    if(!is_dir($path)) mkdir($path, 0777);  // data 폴더가 없다면 생성

    $isOk = true;
    if(is_file("./data/person.json")) {
        $myfile=fopen("./data/person.json", "r");   // person.json 확인
        while(!feof($myfile)) {
            $line=fgets($myfile);
            $check=json_decode($line,true);
            if($check['Name']===$id) {              // 중복 ID 존재 시
                $isOk=false;                        // 진행 불가
                break;
            }
        }
        fclose($myfile);
    }
   
    if(!$isOk) echo json_encode(array('result'=>$isOk));    // 회원가입 실패 시
    else {                                                  // 회원가입 성공 시
        $myfile=fopen("./data/person.json", "a+");
        if(filesize("./data/person.json")!=0) fwrite($myfile, "\n");
        $data = json_encode(array("Name"=>$id, "Password"=>$pwd));
        fwrite($myfile, $data);
        fclose($myfile);    
        echo json_encode(array('result'=>$isOk));
    }
?>