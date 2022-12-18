function modalOpen() {      // 추가 모달 창 열기
    document.querySelector('.modal_wrap').style.display = 'block';
    document.querySelector('.modal_background').style.display = 'block';
    cleanUp();
}
function modalClose() {     // 추가 모달 창 닫기
    document.querySelector('.modal_wrap').style.display = 'none';
    document.querySelector('.modal_background').style.display = 'none';
    cleanUp();
}
function modify_modalOpen() {   // 수정 모달 창 열기
    document.querySelector('.modify_modal_wrap').style.display = 'block';
    document.querySelector('.modify_modal_background').style.display = 'block';
}
function modify_modalClose() {  // 수정 모달 창 닫기
    document.querySelector('.modify_modal_wrap').style.display = 'none';
    document.querySelector('.modify_modal_background').style.display = 'none';
    modifyDoneBtn.replaceWith(modifyBtn);
}

const ok = document.getElementById("ok");               // 등록 버튼
var plan = document.getElementById("plan");             // 일정 내용
var importance = document.getElementById("importance"); // 우선 순위
var startDay = document.getElementById("startDay");     // 시작 요일
var endDay = document.getElementById("endDay");         // 종료 요일
var startTime = document.getElementById("startTime");   // 시작 시간
var endTime = document.getElementById("endTime");       // 종료 시간
const cancel = document.getElementById("cancel");       // 취소 버튼

var modify_plan = document.getElementById("modify_plan");               // 수정 일정 내용
var modify_importance = document.getElementById("modify_importance");   // 수정 우선 순위
var modify_startDay = document.getElementById("modify_startDay");       // 수정 시작 요일
var modify_endDay = document.getElementById("modify_endDay");           // 수정 종료 요일
var modify_startTime = document.getElementById("modify_startTime");     // 수정 시작 시간
var modify_endTime = document.getElementById("modify_endTime");         // 수정 종료 시간
const modifyBtn = document.getElementById("modifyBtn");                 // 수정 버튼
const remove=document.getElementById("remove");                         // 삭제 버튼
const modify_cancel = document.getElementById("modify_cancel");         // 취소 버튼
const modifyDoneBtn = document.createElement("input");                  // 수정완료 버튼
modifyDoneBtn.type="button"; modifyDoneBtn.value="수정완료";

function cleanUp() { // 추가 모달 창 초기화
    plan.value="";
    importance.value="1";
    startDay.value="0";
    endDay.value="0";
    startTime.value="00:00";
    endTime.value="00:00";
}
function cancelPlan() { // 추가 모달 창에서 종료 or 취소 시
    cleanUp();
    modalClose();
}
function okPlan() {     // 등록 시
    if(plan.value=="" || plan.value==null) {        // 일정 validation
        alert("일정을 입력해 주세요.");
        cancelPlan();
        return;
    } else if(endDay.value<startDay.value) {        // 요일 validation
        alert("요일 범위를 올바르게 입력해주세요.");
        cancelPlan();
        return;
    } else if(endTime.value<startTime.value) {      // 시간 validation
        alert("시간 범위를 올바르게 입력해 주세요.");
        cancelPlan();
        return;
    }

    const makeBlock = document.createElement("div");    // 추가 될 일정 block
    const ul = document.createElement("ul");            
    const content1 = document.createElement("li");
    content1.appendChild(document.createTextNode(plan.value));  // 일정 내용
    ul.appendChild(content1);
    const content2 = document.createElement("li");
    content2.appendChild(document.createTextNode("시간 : "+startTime.value+"~"+endTime.value)); // 일정 시간
    ul.appendChild(content2);
    makeBlock.appendChild(ul);
    switch(parseInt(importance.value)){     // 중요도에 따른 색상
        case 1: makeBlock.className="red"; break;
        case 2: makeBlock.className="yellow"; break;
        case 3: makeBlock.className="green"; break;
    }
    content1.id=startDay.value;
    content2.id=endDay.value;
    ul.id=startTime.value;
    makeBlock.id=endTime.value;

    const data=document.getElementById("data");     // 일정 table 접근
    for(let i=parseInt(startDay.value); i<=parseInt(endDay.value); i++) {   // 일정 추가
        const block=makeBlock.cloneNode(true);
        block.addEventListener("click", modify);
        (data.children[i]).appendChild(block);
    }
    sorting();
    cancelPlan();
}

let target;     // 클릭 될 장소
function modify(event) {
    target=event.target;    // target은 수정되는 일정
    modify_modalOpen();
    
    plan.value=modify_plan.value=target.childNodes[0].childNodes[0].childNodes[0].textContent;  // 일정 내용 불러오기
    switch(target.className) {      // 우선 순위 불러오기
        case "red": importance.value=modify_importance.value="1"; break;
        case "yellow": importance.value=modify_importance.value="2"; break;
        case "green": importance.value=modify_importance.value="3"; break;
    }
    startDay.value=modify_startDay.value=target.childNodes[0].childNodes[0].id; // 시작 요일 불러오기
    endDay.value=modify_endDay.value=target.childNodes[0].childNodes[1].id;     // 종료 요일 불러오기
    startTime.value=modify_startTime.value=target.childNodes[0].id;             // 시작 시간 불러오기
    endTime.value=modify_endTime.value=target.id;                               // 종료 시간 불러오기

    modify_plan.disabled=modify_importance.disabled=true;
    modify_startDay.disabled=modify_endDay.disabled=true;                       // 수정 불가능 상태
    modify_startTime.disabled=modify_endTime.disabled=true;

    modifyBtn.addEventListener("click", function() {                            // 수정 버튼 클릭 시
        modify_plan.disabled=modify_importance.disabled=false;
        modify_startDay.disabled=modify_endDay.disabled=false;                  // 수정 가능 상태
        modify_startTime.disabled=modify_endTime.disabled=false;
        modifyBtn.replaceWith(modifyDoneBtn);                                   // 수정완료 버튼으로 교체
    })
}   
function modifyDone() {         // 수정 완료 시
    if(modify_plan.value=="" || modify_plan.value==null) {      // 일정 validation
        alert("일정을 입력해 주세요.");
        modifyDoneBtn.replaceWith(modifyBtn);
        modify_modalClose();
        return;
    } else if(modify_endDay.value<modify_startDay.value) {      // 요일 validation
        alert("요일 범위를 올바르게 입력해주세요.");
        modifyDoneBtn.replaceWith(modifyBtn);
        modify_modalClose();
        return;
    } else if(modify_endTime.value<modify_startTime.value) {    // 시간 validation
        alert("시간 범위를 올바르게 입력해 주세요.");
        modifyDoneBtn.replaceWith(modifyBtn);
        modify_modalClose();
        return;
    }
    
    const tmp = target.cloneNode(true);     // 수정 된 block tmp 생성
    tmp.childNodes[0].childNodes[0].childNodes[0].replaceWith(modify_plan.value);
    tmp.childNodes[0].childNodes[1].childNodes[0].replaceWith(document.createTextNode("시간 : "+modify_startTime.value+"~"+modify_endTime.value))
    switch(parseInt(modify_importance.value)){
        case 1: tmp.className="red"; break;
        case 2: tmp.className="yellow"; break;
        case 3: tmp.className="green"; break;
    }
    tmp.childNodes[0].childNodes[0].id=modify_startDay.value
    tmp.childNodes[0].childNodes[1].id=modify_endDay.value;
    tmp.childNodes[0].id=modify_startTime.value;
    tmp.id=modify_endTime.value;

    if(modify_startDay.value==modify_endDay.value) {    // 종료 요일 수정값이 단일인 경우 
        const moveTo = document.getElementById(modify_startDay.value);
        tmp.addEventListener("click", modify);
        moveTo.appendChild(tmp);
        
        if(startDay.value==endDay.value) target.remove();   // 시작 요일 수정값이 단일인 경우 
        else removeBlock();                                 // 시작 요일 수정값이 다중인 경우
    }
    else {   // 종료 요일 수정값이 다중인 경우
        if(startDay.value==endDay.value) target.remove();   // 시작 요일 수정값이 단일인 경우
        else removeBlock();                                 // 시작 요일 수정값이 다중인 경우
        
        const data=document.getElementById("data");
        for(let i=parseInt(modify_startDay.value); i<=parseInt(modify_endDay.value); i++) {
            const block=tmp.cloneNode(true);
            block.addEventListener("click",modify);
            (data.children[i]).appendChild(block);
        }
    }
    modifyDoneBtn.replaceWith(modifyBtn);   // 수정 버튼으로 교체
    sorting();
    modify_modalClose();
}
modifyDoneBtn.addEventListener("click", modifyDone);

function removeBlock() {        // 삭제 버튼 클릭 시
    const data=document.getElementById("data");
    for(let i=0; i<7; i++) {
        let plans=data.children[i];     // 요일(일~토)
        for(let j=0; j<plans.childElementCount; j++) {
            let check=plans.children[j];    // 각 일정
            if(target.childNodes[0].childNodes[0].childNodes[0].textContent==check.childNodes[0].childNodes[0].childNodes[0].textContent) {
                if(target.childNodes[0].id==check.childNodes[0].id && target.id==check.id) check.remove();
            }   // 일정, 시작 시간, 종료 시간 같으면 삭제
        }
    }
    sorting();
    modify_modalClose();
}
remove.addEventListener("click", removeBlock);
modify_cancel.addEventListener("click", modify_modalClose);

const sort = document.getElementById("sort");   // 정렬 선택
sort.addEventListener("change", sorting);
function sorting() {
    if(sort.value==undefined) return;   // 기본 상태인 경우
    const data = document.getElementById("data");
    for(let i=0; i<7; i++) {
        let day=data.children[i];   // 요일
        let arr=Array.from(day.children);   // 요일 속 일정들 배열
        if(sort.value=="prior") {
            arr.sort(function(a,b) { // 우선순위
                let pivot,compare;
                switch(a.className) {
                    case "red": pivot=1; break;
                    case "yellow": pivot=2; break;
                    case "green": pivot=3; break;
                }
                switch(b.className) {
                    case "red": compare=1; break;
                    case "yellow": compare=2; break;
                    case "green": compare=3; break;
                }
                return pivot-compare;
            }); 
        }
        else if(sort.value=="name") {   // 이름순
           arr.sort(function(a,b) {
                let pivot=a.childNodes[0].childNodes[0].childNodes[0].textContent;
                let compare=b.childNodes[0].childNodes[0].childNodes[0].textContent;
                if(pivot>compare) return 1;
                else if(pivot==compare) return 0;
                else return -1;
           });
        }
        else if(sort.value=="time") {   // 시간순
            arr.sort(function(a,b) {
                let pivot=a.childNodes[0].id;
                let compare=b.childNodes[0].id;
                if(pivot>compare) return 1;
                else if(pivot==compare) return 0;
                else return -1;
            })
        }
        for(let j=0; j<arr.length; j++) {
            let sortedBlock = arr[j];
            day.appendChild(sortedBlock);
        }
    }
};

document.querySelector('#modal_btn').addEventListener('click', modalOpen);
document.querySelector('.modal_close').addEventListener('click', modalClose);
document.querySelector('.modify_modal_close').addEventListener('click', modify_modalClose);
ok.addEventListener("click", okPlan);
cancel.addEventListener("click", cancelPlan);