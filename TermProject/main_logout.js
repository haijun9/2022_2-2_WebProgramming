$("#main").click(function() {location.href='./Main.php';}) // 배너 클릭 시 메인 페이지로
$("#logout").click(function(){  // 로그아웃 버튼 클릭 시
    $.ajax({
        url: "logout.php",    // logout.php로 수행
        success: function() {
            alert("다음에 또 만나요!");
            location.href='./Main.html';  // 메인 페이지로 이동
        }
    })
});
$("#ticketmanage").click(function() {location.href='./ticketmanage.php';}); // 예매확인 클릭 시 페이지 이동

const introduction = document.getElementById("introduction"); // 공연 소개 목록
let arr = Array.from(introduction.children);  // 공연들 배열
$("#title").click(function(){   // 제목순 정렬 클릭 시
  arr.sort(function(a,b) { 
    if(a.id>b.id) return 1;
    else if(a.id==b.id) return 0;
    else return -1;
  });
  for(let i=0; i<arr.length; i++) {introduction.appendChild(arr[i]);}  // 제목순 정렬
});
$("#date").click(function() { // 날짜순 정렬 클릭 시
  arr.sort(function(a,b) { 
    let pivot=new Date(a.className.substring(9, 19));
    let compare=new Date(b.className.substring(9, 19));
    return pivot-compare;
  });
  for(let i=0; i<arr.length; i++) {introduction.appendChild(arr[i]);}  // 날짜순 정렬
});
$("#popu").click(function() { // 인기순 정렬 클릭 시
  $.ajax({
    url: "popu.php",      // popu.php로 수행
    type: "post",
    dataType: "json",
    success:function(data) {
      let keys = Object.keys(data);   // 인기순으로 정렬된 객체
      for(let i in keys) {
        let musical;      // 뮤지컬 제목(한글)
        switch(keys[i]) {
          case "bbalae":  musical="빨래"; break;
          case "deathnote": musical="데스노트"; break;
          case "dracula": musical="드라큘라"; break;
          case "jejuschrist": musical="지저스"; break;
          case "jekyll":  musical="지킬"; break;
          case "kinkyboots":  musical="킹키"; break;
          case "laughman":  musical="웃는"; break;
          case "sweeney": musical="스위니"; break;
        }
        for(let i=0; i<arr.length; i++) {if(arr[i].id==musical) introduction.appendChild(arr[i]);}  // 인기순 정렬
      }
    }
  });
});


// 슬라이드 제작 참고 코드 ----------------------- from https://devinus.tistory.com/48
const slide = document.querySelector(".slide");
let slideWidth = slide.clientWidth; // 슬라이크 전체 크기(width)

// 버튼 엘리먼트 선택
const prevBtn = document.querySelector(".slide_prev_button");
const nextBtn = document.querySelector(".slide_next_button");

let slideItems = document.querySelectorAll(".slide_item"); // 슬라이드 전체 선택
const maxSlide = slideItems.length; // 현재 슬라이드 위치가 슬라이드 개수를 넘기지 않게 하기 위한 변수

let currSlide = 1; // 버튼 클릭할 때 마다 현재 슬라이드가 어디인지 알려주기 위한 변수

const pagination = document.querySelector(".slide_pagination"); // 페이지네이션 생성
for(let i=0; i<maxSlide; i++) {
  if(i===0) pagination.innerHTML += `<li class="active">•</li>`;
  else pagination.innerHTML += `<li>•</li>`;
}
const paginationItems = document.querySelectorAll(".slide_pagination > li");

// 무한 슬라이드를 위해 start, end 슬라이드 복사
const startSlide = slideItems[0];
const endSlide = slideItems[slideItems.length - 1];
const startElem = document.createElement("div");
const endElem = document.createElement("div");

endSlide.classList.forEach((c) => endElem.classList.add(c));
endElem.innerHTML = endSlide.innerHTML;

startSlide.classList.forEach((c) => startElem.classList.add(c));
startElem.innerHTML = startSlide.innerHTML;

// 각 복제한 엘리먼트 추가
slideItems[0].before(endElem);
slideItems[slideItems.length - 1].after(startElem);

// 슬라이드 전체 선택
slideItems = document.querySelectorAll(".slide_item");
let offset = slideWidth + currSlide;
slideItems.forEach((i) => {i.setAttribute("style", `left: ${-offset}px`);});

function nextMove() {
  currSlide++;
  if (currSlide <= maxSlide) {  // 마지막 슬라이드 이상으로 넘어가지 않게 하기 위해
    const offset = slideWidth * currSlide;  // 슬라이드를 이동시키기 위한 offset 계산
    slideItems.forEach((i) => {i.setAttribute("style", `left: ${-offset}px`);}); // 각 슬라이드 아이템의 left에 offset 적용
    // 슬라이드 이동 시 현재 활성화된 pagination 변경
    paginationItems.forEach((i) => i.classList.remove("active"));
    paginationItems[currSlide - 1].classList.add("active");
  } else { // 무한 슬라이드 기능 - currSlide 값만 변경해줘도 되지만 시각적으로 자연스럽게 하기 위해 아래 코드 작성
    currSlide = 0;
    let offset = slideWidth * currSlide;
    slideItems.forEach((i) => {i.setAttribute("style", `transition: ${0}s; left: ${-offset}px`);});
    currSlide++;
    offset = slideWidth * currSlide;
    // 각 슬라이드 아이템의 left에 offset 적용
    setTimeout(() => {
      // 각 슬라이드 아이템의 left에 offset 적용
      slideItems.forEach((i) => {i.setAttribute("style", `transition: ${0.15}s; left: ${-offset}px`);});
    }, 0);
    // // 슬라이드 이동 시 현재 활성화된 pagination 변경
    paginationItems.forEach((i) => i.classList.remove("active"));
    paginationItems[currSlide - 1].classList.add("active");
  }
}
function prevMove() {
  currSlide--; // 1번째 슬라이드 이하로 넘어가지 않게 하기 위해서
  if (currSlide > 0) {
    const offset = slideWidth * currSlide;  // 슬라이드를 이동시키기 위한 offset 계산
    slideItems.forEach((i) => {i.setAttribute("style", `left: ${-offset}px`);}); // 각 슬라이드 아이템의 left에 offset 적용
    // 슬라이드 이동 시 현재 활성화된 pagination 변경
    paginationItems.forEach((i) => i.classList.remove("active"));
    paginationItems[currSlide - 1].classList.add("active");
  } else { // 무한 슬라이드 기능 - currSlide 값만 변경해줘도 되지만 시각적으로 자연스럽게 하기 위해 아래 코드 작성
    currSlide = maxSlide + 1;
    let offset = slideWidth * currSlide;
    slideItems.forEach((i) => {i.setAttribute("style", `transition: ${0}s; left: ${-offset}px`);});  // 각 슬라이드 아이템의 left에 offset 적용
    currSlide--;
    offset = slideWidth * currSlide;
    setTimeout(() => {
      // 각 슬라이드 아이템의 left에 offset 적용
      slideItems.forEach((i) => {i.setAttribute("style", `transition: ${0.15}s; left: ${-offset}px`);});
    }, 0);
    // 슬라이드 이동 시 현재 활성화된 pagination 변경
    paginationItems.forEach((i) => i.classList.remove("active"));
    paginationItems[currSlide - 1].classList.add("active");
  }
}

// 버튼 엘리먼트에 클릭 이벤트 추가
nextBtn.addEventListener("click", () => {nextMove();}); // 이후 버튼 누를 경우 현재 슬라이드를 변경
prevBtn.addEventListener("click", () => {prevMove();}); // 이전 버튼 누를 경우 현재 슬라이드를 변경

// 브라우저 화면이 조정될 때 마다 slideWidth를 변경
window.addEventListener("resize", () => {slideWidth = slide.clientWidth;});

// 각 페이지네이션 클릭 시 해당 슬라이드로 이동
for (let i=0; i<maxSlide; i++) {
  paginationItems[i].addEventListener("click", () => {
    currSlide = i + 1;  // 클릭한 페이지네이션에 따라 현재 슬라이드 변경해주기(currSlide는 시작 위치가 1이기 때문에 + 1)
    const offset = slideWidth * currSlide;  // 슬라이드를 이동시키기 위한 offset 계산
    slideItems.forEach((i) => {i.setAttribute("style", `left: ${-offset}px`);}); // 각 슬라이드 아이템의 left에 offset 적용
    // 슬라이드 이동 시 현재 활성화된 pagination 변경
    paginationItems.forEach((i) => i.classList.remove("active"));
    paginationItems[currSlide - 1].classList.add("active");
  });
}


let loopInterval = setInterval(() => {nextMove();}, 3000);  // 기본적으로 슬라이드 루프 시작
slide.addEventListener("mouseover", () => {clearInterval(loopInterval);}); // 슬라이드에 마우스가 올라간 경우 루프 멈추기
slide.addEventListener("mouseout", () => {loopInterval = setInterval(() => {nextMove();}, 3000);}); // 슬라이드에서 마우스가 나온 경우 루프 재시작하기
// 슬라이드 제작 참고 코드 ----------------------- from https://devinus.tistory.com/48