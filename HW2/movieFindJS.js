function modalOpen() {$(".modal_wrap").show();} // 로그인 모달 창 열기
function modalClose() {$(".modal_wrap").hide();} // 로그인 모달 창 닫기
$("#login").click(modalOpen);           // 로그인 클릭 시
$(".modal_close").click(function(){     // 로그인 창 X 버튼 클릭 시
    $("#input_id").val("");
    $("#input_pwd").val("");
    modalClose();
});

function place_modalOpen() {$(".place_modal_wrap").show();} // 상영관 검색 모달 창 열기
function place_modalClose() {$(".place_modal_wrap").hide();} // 상영관 검색 모달 창 닫기
$(".place_modal_close").click(function(){   // 상영관 검색 창 X 버튼 클릭 시
    $("#people").val("");
    place_modalClose();
});
$("#close").click(function(){       // 상영관 검색 창 닫기 버튼 클릭 시
    $("#people").val("");
    place_modalClose();
});

let login_btn = document.getElementById("login");       // 로그인 버튼
let logout_btn = document.createElement("input");       // 로그아웃 버튼
logout_btn.type = "button";
logout_btn.value = "로그아웃";
logout_btn.id = "logout";
logout_btn.addEventListener("click", function() {       // 로그아웃 버튼 클릭 시
    $.ajax({
        url: "logout.php",                              // logout.php로 수행
        success: function() {
            alert("로그아웃이 되었습니다.");
            logout_btn.previousSibling.remove();
            logout_btn.replaceWith(login_btn);
        }
    })
});

let valid_id = RegExp(/^([A-Za-z0-9]){6,15}$/);                                         // ID 입력 양식
let valid_pwd = RegExp(/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/);   // Password 입력 양식
$("#Submit").click(function() {     // Submit 버튼 클릭 시
    if($("#input_id").val()=="" || $("#input_pwd").val()=="" || valid_id.test($("#input_id").val())==false          // Validation
        || valid_pwd.test($("#input_pwd").val())==false) alert("아이디 또는 패스워드의 입력양식을 체크해주세요.");
    else{
        $.ajax({
            url: "submit.php",      // submit.php로 수행
            type: "post",
            data: {id: $("#input_id").val(), pwd: $("#input_pwd").val()},
            dataType: "json",
            success:function(data) {
                if(data.result==true) {             // 로그인 성공
                    login_btn.replaceWith(logout_btn);
                    logout_btn.before(data.id+" ");
                }
                else alert("아이디와 비밀번호가 올바른지 확인해주세요.");   // 로그인 실패
            }
        });
    }
    $("#input_id").val("");
    $("#input_pwd").val("");
    modalClose();
});
$("#Signin").click(function() {     // Signin 버튼 클릭 시
    if($("#input_id").val()=="" || $("#input_pwd").val()=="" || valid_id.test($("#input_id").val())==false          // Validation
        || valid_pwd.test($("#input_pwd").val())==false) alert("아이디 또는 패스워드의 입력양식을 체크해주세요.");
    else {
        $.ajax({
            url: "signin.php",      // signin.php로 수행
            type: "post",
            data: {id: $("#input_id").val(), pwd: $("#input_pwd").val()},
            dataType: "json",
            success:function(data) {
                if(data.result==true) alert("회원가입이 완료되었습니다.");  // 회원가입 성공
                else alert("이미 존재하는 ID입니다.");                      // 중복 ID 가입 시
            }
        });
    }
    $("#input_id").val("");
    $("#input_pwd").val("");
    modalClose();
});

$("#search").click(function() {     // 검색 버튼 클릭 시
    $.ajax({
        url: "search_info.php",     // search_info.php로 수행
        type: "post",
        data: {info: $("#search_info").val()},
        dataType: "json",
        success: function(data){
            $("#search_result").empty();            // table 초기화
            var table_set = '';
            table_set += '<tr>';
            table_set += '<th>선택</th><th>영화 제목</th><th>장르</th><th>감독</th><th>배우</th><th>화일</th>';
            table_set += '</tr>';
            $("#search_result").append(table_set);  // table 헤더 구성
            for(let i=0; i<data.length; i++) {      // 검색 내용 table에 추가
                var table_add = '<tr>';
                table_add += '<td><input type="radio" name="choice" value="'+data[i].id+'"></td>';
                table_add += '<td>'+data[i].movie_name+'</td>';
                table_add += '<td>'+data[i].genre+'</td>';
                table_add += '<td>'+data[i].director+'</td>';
                table_add += '<td>'+data[i].actors+'</td>';
                table_add += '<td><a target="_blank" href="'+data[i].file_name+'">미리보기</a></td>';
                table_add += '</tr>';
                $("#search_result").append(table_add);
            }
            $("#search_btn").show();            // 상영관 검색 버튼 등장
            $("#search_btn").click(function(){  // 상영관 검색 버튼 클릭 시
                place_modalOpen();
                var radioVal = $('input[name="choice"]:checked').val();
                $.ajax({
                    url: "search_place.php",    // search_place로 수행
                    type: "post",
                    data: {id: radioVal},
                    dataType: "json",
                    success: function(data) {
                        $("#place").empty();                // table 초기화
                        var table_set = '';
                        var table_set = '';
                        table_set += '<tr>';
                        table_set += '<th>선택</th><th>상영 날짜</th><th>상영관</th><th>예약수</th>';
                        table_set += '</tr>';
                        $("#place").append(table_set);      // table 헤더 구성
                        for(let i=0; i<data.length; i++) {  // 상영 내용 table에 추가
                            var table_add= '<tr>';
                            table_add += '<td><input type="radio" name="place_choice" value="'+data[i].id+'"></td>';
                            table_add += '<td>'+data[i].date+'</td>';
                            table_add += '<td>'+data[i].screening_id+'</td>';
                            table_add += '<td>'+data[i].reserve_seat+'</td>';
                            table_add += '</tr>';
                            $("#place").append(table_add);
                        }
                    }
                });
            });
        }
    });
});

$("#reserve").click(function(){     // 예약 버튼 클릭 시
    if($("#people").val()>10) {     // 한번에 최대 10명까지
        alert("한 번에 최대 10명까지 예약 가능합니다.");
        return;
    } 
    var place_radioVal = $('input[name="place_choice"]:checked').val();
    $.ajax({
        url: "reserve.php",     // reserve.php로 수행
        type: "post",
        data: {id: place_radioVal, people:$("#people").val()},
        dataType: "json",
        success: function(data) {
            if(data.result==false) alert("로그인 후 영화 예약이 가능합니다.");      // 미로그인 시
            else {
                if(data.max==false) alert("하나의 상영관의 최대 수용 인원은 20명까지입니다.");  // 인원 초과
                else {      // 예약 성공
                    alert("예약되었습니다.");
                    $("#people").val("");
                    place_modalClose();
                }
            }
        }
    })
});

$("#reserved_info").click(function(){       // 예약정보 클릭 시
    $.ajax({
        url: "reserved_info.php",           // reserved_info.php로 수행
        type: "post",
        dataType: "json",
        success: function(data) {
            if(data.result==false) alert("로그인 후 예약 정보 보기가 가능합니다."); // 미로그인 시
            else window.open("user_reserved.php");  // 로그인 시 user_reserved.php 창 띄우기
        }
    })
});