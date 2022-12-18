<?php
    session_start();    // 세션 시작

    $isLogin=false;
    if(isset($_SESSION['id'])) $isLogin=true;   // 세션 id 존재 시 로그인 상태
    
    echo json_encode(array('result'=>$isLogin));
?>