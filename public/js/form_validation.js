function setAddModal(){
    var today = new Date();
    var now_str = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) 
                + '-' + ('0' + today.getDate()).slice(-2) + 'T' + '00:00';
    document.getElementById("datetime").min = now_str;
}

function sendTodo(){
    if(validation()){
        document.todoForm.submit();
    }
}

function validation(){
    var con_valid = document.getElementById('con_valid');
    var dt_valid = document.getElementById('dt_valid');

    con_valid.textContent = '';
    dt_valid.textContent = '';

    var content = document.getElementById('content').value;
    var dt = document.getElementById('datetime').value;
    
    var flag = true;

    if(!content){
        flag = false;
        con_valid.textContent = '作業内容を入力してください';
    }
    if(content.length > 50){
        flag = false;
        con_valid.textContent = '50文字以内で入力してください';
    } 
    if(!dt){
        flag = false;
        dt_valid.textContent = '予定日時を入力してください';
    }

    return flag;
}

function deleteMsg(){
    var con_valid = document.getElementById('con_valid');
    var dt_valid = document.getElementById('dt_valid');

    con_valid.textContent = '';
    dt_valid.textContent = '';
}

function formSwitch(){
    document.getElementById('dt_valid').textContent = '';

    var check = document.getElementsByClassName('dt-radio');
    var dtForm = document.getElementById('datetime');
    if(check[0].checked) {
        dtForm.style.display = "block";
    }
    else if(check[1].checked){
        dtForm.style.display = "none";
        dtForm.value = '';
    }
}

function inputChange(ele){
    var valid_id = '';
    var id = ele.getAttribute("id");

    if (id == 'content'){
        valid_id = 'con_valid';
    }
    else if(id == 'datetime'){
        valid_id = 'dt_valid';
    }
    else if(id == 'ud_content'){
        valid_id = 'ud_con_valid';
    }
    else if(id == 'ud_pa'){
        valid_id = 'ud_pa_valid';
    }
    else if(id == 'ud_fa'){
        valid_id = 'ud_fa_valid';
    }

    document.getElementById(valid_id).textContent = '';
}

function setUpdateModal(ele){
    var ud_pa = document.getElementById('ud_pa');
    var ud_fa = document.getElementById('ud_fa');
    ud_pa.value = '';
    ud_fa.value = '';
    
    var id = ele.getAttribute("id").replace(/[^0-9]/g, '');
    var content = document.getElementById('content_' + id).textContent;
    var planed_at = document.getElementById('pa_' + id).textContent.trim();
    var finished_at = document.getElementById('fa_' + id).textContent.trim();

    document.getElementById('ud_content').value = content;

    var date = document.getElementById("calendar").value.replace('/', '-');
    var today = new Date();
    var today_str = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) 
                + '-' + ('0' + today.getDate()).slice(-2);

    min_str = date + 'T' + '00:00';
    max_str = date + 'T' + '23:59';

    if(finished_at !== '-' || (finished_at == '-' && date < today_str)){
        document.getElementById('fa_div').style.display = "block";
        fa_str = date + 'T' + finished_at;
        ud_fa.value = fa_str;
        ud_fa.min = min_str;
        ud_fa.max = max_str;

        document.getElementById('pa_div').style.display = "none";
    }
    else{  
        document.getElementById('pa_div').style.display = "block";
        pa_str = date + 'T' + planed_at;
        ud_pa.value = pa_str;
        ud_pa.min = min_str;

        document.getElementById('fa_div').style.display = "none";
    }

    document.getElementById('col_key').value = id;
    document.getElementById('todoId').value = document.getElementById('id_' + id).value;
}

function update_validation(){
    var con_valid = document.getElementById('ud_con_valid');
    var pa_valid = document.getElementById('ud_pa_valid');
    var fa_valid = document.getElementById('ud_fa_valid');

    con_valid.textContent = '';
    pa_valid.textContent = '';
    fa_valid.textContent = '';

    // updateのモーダルの内容
    var content = document.getElementById('ud_content').value;
    var pa = document.getElementById('ud_pa').value;
    var fa = document.getElementById('ud_fa').value;

    var date = document.getElementById("calendar").value.replace('/', '-');
    var today = new Date();
    var today_str = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) 
                + '-' + ('0' + today.getDate()).slice(-2);

    var flag = true;

    if (!content){
        flag = false;
        con_valid.textContent = '作業内容を入力してください';
    }
    if(content.length > 50){
        flag = false;
        con_valid.textContent = '50文字以内で入力してください';
    } 

    var id = document.getElementById('col_key').value;
    var finished_at = document.getElementById('fa_' + id).textContent.trim();

    if(!pa && document.getElementById('pa_div').style.display == "block"){
        flag = false;
        pa_valid.textContent = '予定日時を入力してください';
    }
    
    if(!fa && document.getElementById('fa_div').style.display == "block"){
        flag = false;
        fa_valid.textContent = '完了時間を入力してください';
    }

    return flag;
}

function changeDelete(){
    var delBtn = document.getElementById("del-btn");
    var finBtn = document.getElementById("fin-btn");
    var checks = document.getElementsByClassName("del-check");
    var finished_ats = document.getElementsByClassName("fa");
    var delFlag = false;
    var finFlag = true;
    var date = document.getElementById("calendar").value.replace('/', '-');
    var today = new Date();
    var today_str = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) 
                + '-' + ('0' + today.getDate()).slice(-2);

    for (let i = 0; i < checks.length; i++){
        if(checks[i].checked){
            delFlag = true;
            if(finished_ats[i].textContent.trim() != '-'){
                finFlag = false;
            }
        }
    }

    if(delFlag){
        delBtn.style.display = "block";
        if(finFlag && date == today_str){
            finBtn.style.display = "block";    
        }
        else{
            finBtn.style.display = "none";   
        }    
    }
    else{
        delBtn.style.display = "none";
        finBtn.style.display = "none";
    }
    
}
