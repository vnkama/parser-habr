

function pageReady()
{
    document.getElementById('id-button-ok').onclick = idButtonOk_onclick;
}


/**
 * обработчик нажатия кнопки ОК
 */
function idButtonOk_onclick()
{

    //////////////////////////////////////////
    // проверим формат логина

    let login = document.getElementById('id-input-login').value.trim();
    let eLoginMess = document.getElementById('id-login-message');

    let exit = 0;



    let loginLen = login.length;
    if (!loginLen) {
        eLoginMess.innerHTML = 'Введите логин';
        exit = 1;
    }
    else if (loginLen<3 || loginLen>10) {
        eLoginMess.innerHTML = 'Длинна логина от 3 до 10 символов';
        exit = 1;
    }
    else if (!/^[A-z\d]+$/.test(login)) {
        eLoginMess.innerHTML = 'Некорректный символ в логине';
        exit = 1;
    }
    else {
        eLoginMess.innerHTML = '';
    }

    //////////////////////////////////////////
    // проверим формат пароля

    let pass = document.getElementById('id-input-password').value;
    var ePassMess = document.getElementById('id-password-message');

    let passLen = pass.length;
    if (!passLen) {
        ePassMess.innerHTML = 'Введите пароль';
        exit = 1;
    }
    else if (passLen<3 || passLen>10) {
        ePassMess.innerHTML = 'Длинна пароля от 3 до 10 символов';
        exit = 1;
    }
    else if (!/^[A-z\d]+$/.test(pass)) {
        ePassMess.innerHTML = 'Некорректный символ в пароле';
        exit = 1;
    }
    else {
        ePassMess.innerHTML = '';
    }

    //если были ошибки на выход
    if (exit) return;


    //отправим данные на проверку
    let arrPost = {
        operation:  'testLoginPassword',
        login:      encodeURIComponent(login),
        password:   encodeURIComponent(pass)
    }

    let xhr = new XMLHttpRequest();
    xhr.open('post','start.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function()
    {
        if (this.readyState == 4){
            if (this.status != 200){alert('Ошибка связи. http status:' + this.status);return;}


            let arrPostAnswer = JSON.parse(xhr.responseText);
            if (!('errorMessage' in arrPostAnswer)) {alert('Ошибка связи. Нет поля errorMessage');return;}
            if (arrPostAnswer['errorMessage'] != 'OK'){alert('errorMessage:\r\n' + arrPostAnswer['errorMessage']);return;}

            if (!('passwordResult' in arrPostAnswer)) {alert('Ошибка связи. Нет поля passwordResult');return}

            //получен ответ
            if (arrPostAnswer['passwordResult']) {
                //пароль верный
                //редирект на главную
                document.location.href = '/index';
            }
            else {
                //неверный пароль
                ePassMess.innerHTML = 'НЕВЕРНЫЙ ПАРОЛЬ';
            }
        }
    }
    xhr.send("routeName=login&jsonPostRequest=" + JSON.stringify(arrPost));
}

