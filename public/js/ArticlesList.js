/*
файл js скрипты для страницы индекс /index
*/


var pageNumber=1

/**
 * вызыватся из ready()
 */
function pageReady()
{
    setPaginationOnclicks();
}

function setPaginationOnclicks()
{
    let elems = document.getElementsByClassName('js-pagination');       //
    let len=elems.length;
    for (let i=0;i<len;i++) {
        elems[i].onclick = pagination_onclick;
    }

}


//
// клик по кнопке пагинатора
// запрашиваем через POST другую стрницу с 5ю првеью статей
//
function pagination_onclick()
{
    alert('pagination_onclick'+this.getAttribute('data-newtab'));

    let arrPostRequest = {
        operation:  'getTab',
        tabNumber:  this.getAttribute('data-newtab')
    }

    g_sendPostRequest('index',arrPostRequest,postRequest_getTab_OK);

}

function postRequest_getTab_OK(arrPostAnswer)
{
    document.getElementById('id-tab').innerHTML = arrPostAnswer['newTab'];

    //заново настроим обработчики кликов
    setPaginationOnclicks();
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


