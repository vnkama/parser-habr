/*
файл js скрипты для страницы индекс /index
*/


var pageNumber=1

/**
 * вызыватся из ready()
 */
function pageReady()
{
    setPaginationReload();
}

function setPaginationReload()
{
    _setOnclickByClass('js-pagination',pagination_onclick);
    _setOnclickByClass('js-button-see-full',buttonSeeFull_onclick);
}


//
// клик по кнопке пагинатора
// запрашиваем через POST другую стрницу с 5ю првеью статей
//
function pagination_onclick()
{
    let arrPostRequest = {
        operation:  'getTab',
        tabNumber:  this.getAttribute('data-newtab')
    }

    _sendPostRequest('index',arrPostRequest,postRequest_getTab_OK);
}


function postRequest_getTab_OK(arrPostAnswer)
{
    document.getElementById('id-tab').innerHTML = arrPostAnswer['newTab'];

    //заново настроим обработчики кликов
    setPaginationReload();
}


function buttonSeeFull_onclick()
{
    let arrPostRequest = {
        operation:  'getArticle',
        idArticle:  this.getAttribute('data-id-article')
    }

    _sendPostRequest('index',arrPostRequest,postRequest_getArticle_OK);
}


function postRequest_getArticle_OK(arrPostAnswer)
{
    //arrPostAnswer['Article']['mainText'];
    //$.fancybox.open(arrPostAnswer['Article']['mainText']);

    document.getElementById('id-modal-article').innerHTML = '<h2>' + arrPostAnswer['Article']['title'] + '</h2><br>' + arrPostAnswer['Article']['mainText'];

        $.fancybox.open({
        src  : '#id-modal-article',
        type : 'inline',
        opts : {
            modal: false,
            buttons: [
                "close"
            ],
            fullScreen: {
                autoStart: true,
                requestOnStart : true
            },
        }
    });

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


