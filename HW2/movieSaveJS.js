const actors = document.getElementById("actors");           // 출연자 구역 
const actor_add = document.getElementById("actor_add");     // 출연자 추가 버튼
actor_add.addEventListener("click", function() {            // 출연자 추가
    if(actors.childElementCount>=5) return;
    let input = document.createElement("input");
    input.type="text";
    input.name="actor[]";
    input.id="actor";
    actors.insertBefore(input, actors.childNodes[0]);
});
const actor_del = document.getElementById("actor_del");     // 출연자 삭제 버튼
actor_del.addEventListener("click", function() {            // 출연자 삭제
    if(actors.childElementCount<=3) return;                 
    actors.removeChild(actors.firstChild);
});

const when = document.getElementById("when");               // 상영 날짜 구역
const search = document.getElementById("search");           // 상영관 검색
const when_add = document.getElementById("when_add");       // 상영 정보 추가
const one = document.getElementById("one");                 // 상영관1
const two = document.getElementById("two");                 // 상영관2
const three = document.getElementById("three");             // 상영관3
const more = document.getElementById("more");               // 추가된 상영 정보
search.addEventListener("click", function() {               // 상영관 검색 -> 활성화
    if(when.value == "") return; 
    when_add.disabled = false;
    one.disabled = false;
    two.disabled = false;
    three.disabled =false;
});
when_add.addEventListener("click", function() {             // 상영 정보 추가 -> 비활성화
    let isok = true;
    for(let i=0; i<more.childElementCount; i++) {           
        if(more.childNodes[i].id==when.value) isok=false;
    }
    when_add.disabled = true;
    one.disabled=true;
    two.disabled=true;
    three.disabled=true;
    if(isok==false) {                                       // 하루에 하나의 상영관 가정
        alert("같은 날짜에 이미 추가되었습니다.");
        return;
    }

    let add = document.createElement("input");
    add.id=when.value;
    add.type="text";
    add.name="place[]";
    add.classList="place";
    if(one.checked) add.value=when.value+",상영관1";
    else if(two.checked) add.value=when.value+",상영관2";
    else if(three.checked) add.value=when.value+",상영관3";
    more.appendChild(add);
    more.appendChild(document.createElement("br"));
});
