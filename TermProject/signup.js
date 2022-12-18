$("#login").click(modalOpen); // 로그인 버튼 클릭 시
function modalOpen() {      // 로그인 모달 창 열기
  document.querySelector('.modal_wrap').style.display = 'block';
  document.querySelector('.modal_background').style.display = 'block';
}
$("#cancel").click(modalClose); // 로그인에서 취소 버튼 클릭 시
document.querySelector('.modal_close').addEventListener("click", modalClose); // X 버튼 클릭 시
function modalClose() {     // 로그인 모달 창 닫기
  document.querySelector('.modal_wrap').style.display = 'none';
  document.querySelector('.modal_background').style.display = 'none';
  $("#ID").val("");
  $("#pwd").val("");
}
  
$("#main").click(function() {location.href='./Main.html';})     // 배너 클릭 시
$("#signup").click(function(){location.href='./SignUp.html';})  // 회원가입 클릭 시 
$("#back").click(function(){location.href='./Main.html';})      // 취소 버튼 클릭 시

$("#ok").click(function(){    // 로그인 시도 시
  if($("#ID").val()=="" ||  $("#pwd").val()=="") alert("아이디 또는 패스워드가 모두 입력되었는지 확인해주세요.");
  // validation 실패 시
  else {  // validation 성공 시
      $.ajax({
          url: "login.php",      // login.php로 수행
          type: "post",
          data: {id: $("#ID").val(), pwd: $("#pwd").val()}, // 아이디와 비밀번호 전달
          dataType: "json",
          success:function(data) {
            if(data.result==true) {             // 로그인 성공
              alert("환영합니다! " + data.name + "님!");
              modalClose();
              location.href='./Main.php';       // 메인-로그인 상태로 이동
            }
            else alert("존재하지 않는 회원입니다. 아이디와 비밀번호를 확인해주세요.");   // 로그인 실패
        }
      });
  }
});

let valid_id = RegExp(/^([A-Za-z0-9]){6,15}$/);                                         // ID 입력 양식
let valid_pwd = RegExp(/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/);   // Password 입력 양식
$("#submit").click(function() {     // submit 버튼 클릭 시
  if($("#name").val()=="" || $("#input_ID").val()=="" || $("#pwd1").val()=="" || $("#pwd2").val()=="" || 
    valid_id.test($("#input_ID").val())==false || valid_pwd.test($("#pwd1").val())==false) alert("아이디 또는 패스워드의 입력양식을 체크해주세요.");
  // 입력 ID와 pwd validation 실패 시
  else if($("#pwd1").val()!=$("#pwd2").val()) alert("입력하신 두 비밀번호가 일치하지 않습니다."); // 두 pwd 일치하지 않을 시
  else {  // 모든 validation 통과 시
      $.ajax({
          url: "signup.php",      // signup.php로 수행
          type: "post",
          data: {name: $("#name").val(), id: $("#input_ID").val(), pwd: $("#pwd1").val()}, // 이름, 아이디, 비밀번호 전달
          dataType: "json",
          success:function(data) {
              if(data.result!=true) alert("이미 존재하는 ID입니다");   // 중복 ID 가입 시
              else {
                alert("회원가입에 성공하였습니다.");                   // 회원가입 성공
                location.href='./Main.html';                         // 메인-비로그인 상태로 이동
              }
          }
      });
  }
});