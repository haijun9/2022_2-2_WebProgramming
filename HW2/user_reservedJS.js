$("#cancel").click(function(){              // 예매 취소 버튼 클릭 시
    $(".reserved:checked").each(function(){ // 체크된 항목들 순회
        $.ajax({
            url: "cancel.php",  // cancel.php로 수행
            type: "post",
            data: {id: $(this).val()},
        })
    });
    alert("예약이 취소되었습니다.");
    location.reload();          // 페이지 새로고침
});