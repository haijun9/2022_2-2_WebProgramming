$("#main").click(function() {location.href='./Main.php';})  // 배너 클릭시 메인(로그인)으로 이동
$("#ticketmanage").click(function() {location.href='./TicketManage.php';})  // 예매 확인 클릭시 새로고침

$("#logout").click(function() {       // 로그아웃 버튼 클릭 시
    $.ajax({
        url: "logout.php",            // logout.php로 수행
        success: function() {
            alert("다음에 또 만나요!");
            location.href='./Main.html';    // 메인(비로그인)으로 이동
        }
    })
});

let buttons = document.getElementsByClassName("buttons");   // 모든 예매 취소 버튼들
for(let i=0; i<buttons.length; i++) {
    buttons[i].addEventListener("click", function() {   // 예매 취소 클릭 시
        let reserve_no = this.id;   // 예매 번호
        if(confirm("정말 이 표를 취소하시겠습니까?")) {
            $.ajax({
                url: "cancel_ticket.php",   // cancel_ticket.php로 수행
                type: "post",
                data: {reserve_no: reserve_no}, // 예매 번호 전달
                success:function() {
                    alert("예매가 취소되었습니다.");
                    location.href='./ticketmanage.php'; // 페이지 새로고침
                }
            }); 
        }
    });
}