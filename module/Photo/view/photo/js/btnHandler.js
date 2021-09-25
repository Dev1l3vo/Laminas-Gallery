img = document.getElementById('img');
nextBtn = document.getElementById('nextImg');
prevBtn = document.getElementById('prevImg');
ajaxReq = new XMLHttpRequest();
imgNext = int(document.getElementById('idPhoto').value)+1;

nextBtn.addEventListener('click',(event)=>{
    event.preventDefault();
    // ajaxReq.open('GET',nextBtn.href);
    // ajaxReq.onreadystatechange = function() {//Call a function when the state changes.
    //     if(ajaxReq.readyState == 4 && ajaxReq.status == 200) {
    //         console.log(ajaxReq.responseText.imgNext);
    //         img.src = "data:image/png;base64,"+ajaxReq.responseText.imgNext;
    //     }
    // }
    // ajaxReq.send(params);
    console.log("hello");
})