$("#main").click(function() {location.href='./Main.php';})  // 배너 클릭 시 메인페이지(로그인)로 이동
$("#logout").click(function() {       // 로그아웃 버튼 클릭 시
    $.ajax({
        url: "logout.php",     // logout.php로 수행
        success: function() {
            alert("다음에 또 만나요!");
            location.href='./Main.html';    // 메인페이지(비로그인)로 이동
        }
    })
});
$("#ticketmanage").click(function() {location.href='./ticketmanage.php';}); // 예매확인 클릭 시 페이지 이동

let musical = $('img').attr('alt'); // 현재 예매 하려는 뮤지컬 종류
switch(musical) {   // 뮤지컬에 따른 날짜 선택 조정 
    case "bbalae": $("#date").attr({"min":"2022-06-10", "max":"2023-01-29"}); break;
    case "deathnote": $("#date").attr({"min":"2022-04-05", "max":"2022-06-26"}); break;
    case "kinkyboots": $("#date").attr({"min":"2022-07-20", "max":"2022-10-23"}); break;
    case "dracula": $("#date").attr({"min":"2021-05-18", "max":"2021-08-01"}); break;
    case "jejuschrist": $("#date").attr({"min":"2022-11-10", "max":"2023-01-15"}); break;
    case "laughman": $("#date").attr({"min":"2022-06-10", "max":"2022-08-22"}); break;
    case "jekyll": $("#date").attr({"min":"2021-10-19", "max":"2022-05-08"}); break;
    case "sweeney": $("#date").attr({"min":"2022-12-01", "max":"2023-03-05"}); break;
}

const day = document.getElementById("date");            // 날짜 선택
const when = document.getElementsByTagName("select");   // 부(시간) 선택
const casting = document.getElementById("casting");     // 캐스팅 목록
let musicalExist = false, startingTime;                 // 해당 공연 존재 여부, 시작 시간
function castInfo() {
    $.ajax({
        url: "casting.php",      // casting.php로 수행
        type: "post",
        data: {musical: musical, date: day.value, time: $("select[name=when]").val()},  // 뮤지컬 이름, 날짜, 부(시간) 전달
        dataType: "json",
        success:function(data) {
            $("#casting").empty();  // 캐스팅 목록 초기화
            if(data!=""){ // 해당 날짜&시간에 공연 존재 시
                let append = "<h5>캐스팅 일정</h5><br><ul>"
                for(var key in data[0]) {
                    if(key=='date' || key=='day') continue;
                    else if(key=='time') {
                        startingTime = data[0][key];    // 공연 시작 시간 따로 저장
                        continue;
                    }
                    append += "<li>" + key + "役 : " + data[0][key] +"</li>";   // 캐스팅 목록 안내
                }
                append += "</ul>";
                $("#casting").html(append); // 캐스팅 목록 안내
                musicalExist = true;    // 해당 공연 존재로 상태 변경
                $.ajax({
                    url: "reserved_seat.php",   // reserved_seat.php로 수행
                    type: "post",
                    data: {date: day.value, startingTime: startingTime, musical: $('img').attr('alt')}, // 날짜, 시작시간, 뮤지컬 이름 전달
                    dataType: "json",
                    success:function(data) {
                        for(let div of seat_Set.children) {     // 좌석 선택 목록들에 대해서
                            for(let seat of div.children) {     // 좌석들에 대해서
                                if(data.includes(seat.id)) {    // 이미 예매된 좌석인 경우
                                    seat.removeEventListener("click", choose);  // 선택 불가능하게 변경
                                    seat.style.background="black";
                                    seat.style.color="black";   
                                }
                                else {  // 그렇지 않은 경우 정상적으로 진행
                                    seat.addEventListener("click", choose);
                                    seat.style.background="darkgray";
                                    seat.style.color="white";
                                }
                            }
                        }
                    }
                });
            }
            else {  // 해당 날짜&시간에 공연이 없을 시
                alert("해당 날짜 또는 시간에는 공연이 없습니다!");  
                musicalExist = false;   // 해당 공연 부재로 상태 변경
            }
        }
    });
}
$("#date").change(castInfo);    // 날짜 변경 시 캐스팅 목록 안내
$("#when").change(castInfo);    // 부(시간) 변경 시 캐스팅 목록 안내

let selected_seat=[];   // 현재까지 선택한 좌석
const seat_Set = document.querySelector(".seat_Set");       // 좌석 선택 창
function choose(event) {                            // 빈 좌석 선택 시
    if(selected_seat.length>=2) {                   // 좌석 2개 이상 선택 시 안내
        alert("인당 최대 2좌석 예매 가능합니다!");
        return;
    }
    let target = event.target;
    target.style.background="red";                  // 배경 빨간색으로 변경
    target.addEventListener("click", unchoose);     
    target.removeEventListener("click", choose);    // unchoose 이벤트로 변경
    selected_seat.push(target.id);                  // 현재까지 선택한 좌석에 추가
}
function unchoose(event) {                          // 좌석 선택 해제 시
    let target = event.target;  
    target.style.background="darkgray";             // 배경 어두운 회색으로 변경
    target.addEventListener("click", choose);
    target.removeEventListener("click", unchoose);  // choose 이벤트로 변경
    selected_seat = selected_seat.filter((element) => element !== target.id);   // 현재까지 추가한 좌석에서 해제
}
for(let i=0; i<9; i++) {                            // 9줄 생성
    let div = document.createElement("div");
    seat_Set.append(div);
    for(let j=1; j<=8; j++) {                       // 줄 당 8자리
        const input = document.createElement('input');
        input.type="button";
        input.name="seats"
        input.classList="seat";                     // seat class로 관리
        switch(i) {
          case 0: input.id=input.value="A"+j; break;         // A열부터
          case 1: input.id=input.value="B"+j; break;
          case 2: input.id=input.value="C"+j; break;
          case 3: input.id=input.value="D"+j; break;
          case 4: input.id=input.value="E"+j; break;
          case 5: input.id=input.value="F"+j; break;
          case 6: input.id=input.value="G"+j; break;
          case 7: input.id=input.value="H"+j; break;
          case 8: input.id=input.value="J"+j;                // J열까지
        }
        input.addEventListener("click", choose);    // choose 이벤트 부착
        div.append(input);
    }
}

$("#ok").click(function() {     // 예매 시도 시
    if(!musicalExist || selected_seat.length==0) {      // 공연이 존재하지 않거나 좌석을 선택하지 않은 경우 안내
        alert("예매할 정보가 올바른지 확인해주세요.");
        return;
    }
    $.ajax({
        url: "reserve.php",      // reserve.php로 수행
        type: "post",
        data: {musical: musical, date: day.value, time: $("select[name=when]").val(),   
            startingTime: startingTime, seat: selected_seat, people: selected_seat.length}, // 예매 관련 정보 모두 전달
        success:function() {
            selected_seat=[];           // 현재까지 선택한 좌석 초기화
            alert("예매에 성공하였습니다!\n예매 정보는 예매확인 창에서 확인 가능합니다!");
            location.href='./Main.php'; // 메인(로그인) 페이지로 이동
        }
    });
});
$("#cancel").click(function() {location.href='./Main.php';})  // 취소 시 메인(로그인) 페이지로