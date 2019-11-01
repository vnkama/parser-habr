/*
файл js скрипты для страницы индекс /index
*/


var pageNumber=1

/**
 * вызыватся из ready()
 */
function pageReady()
{
    // если ссылка на выход сущестует, вешаем обрабочтки
    // let elem = document.getElementById('id-logoff');
    // if (elem) elem.onclick = idLogoff_onclick;page-item
    //alert('pageReady');

    elems = document.getElementsByClassName('js-pagination');       //
    for (let i=0;i<elems.length;i++) {
        elems[i].onclick = pagination_onclick;
    }

}


//
// клик по кнопке пагинатора
// запрашиваем через POST другую стрницу с 5ю првеью статей
//
function pagination_onclick()
{

    let arrPostRequest = {
        operation:  'getPage',
        pageNumber: this.getAttribute('data-newpage')
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

            //ответ


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
    xhr.send("routeName=login&jsonPostRequest=" + JSON.stringify(arrPostRequest));


}


//
// обработчик кнопок показать статью целиком
//
function showFullArticel_onclick()
{
    //запрашиваем полный текст статьи
    alert('showFullArticel_onclick');

}

//
//показывает фенсибокс с полным текстом статьи
//
function showFancy4Articel(fullText)
{
    alert('showFancy4Articel');

}


//
// перерисовывет пагинатор
//
function redrawPaginator(htmlPaginator)
{
    // htmlPaginator - html код пагинатора
    //
    // если htmlPaginator===null то пагинатор скрываем
    //
    alert('redrawPaginator');



}

//
// перерисовыаем блок превью на странице
//
function  redrawPreviewsBox(htmlPreviews)
{

}


