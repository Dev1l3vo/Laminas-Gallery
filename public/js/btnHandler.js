
img = document.getElementById('img');
nextBtn = document.getElementById('nextImg');
prevBtn = document.getElementById('prevImg');
imgName = document.getElementById('imgName');
deleteTag = document.getElementById('deleteImg');
ajaxReq = new XMLHttpRequest();
errorObj = document.getElementById('error');

function BtnHandler(event){
    event.preventDefault();
    ajaxReq.open('GET',event.target.href);
    ajaxReq.onreadystatechange = function() {//Call a function when the state changes.
        if(ajaxReq.readyState == 4 && ajaxReq.status == 200) {
            jsonResp = JSON.parse(ajaxReq.responseText);
            if(jsonResp.error){
                errorObj.classList.add('bg-red-400');
                errorObj.classList.remove('hidden');
                errorObj.innerText = jsonResp.error;
            }else{
                img.src = "data:image/png;base64,"+jsonResp.encode_photo;
                imgName.innerText = jsonResp.name;
                nextBtn.href = '/photo/next/'+ (parseInt(jsonResp.id)+1);
                prevBtn.href = '/photo/prev/'+ (parseInt(jsonResp.id)-1 < 0 ? 0 : parseInt(jsonResp.id)-1);
                deleteTag.href = '/photo/delete/'+ (parseInt(jsonResp.id));
                errorObj.classList.add('hidden');
            }
            
        }
    }
    ajaxReq.send(); 
}

nextBtn.addEventListener('click',BtnHandler);
prevBtn.addEventListener('click',BtnHandler);
