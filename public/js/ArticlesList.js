/*
файл js скрипты для страницы индекс /index
*/


var pageNumber=1

/**
 * вызыватся из ready()
 */
function pageReady()
{
    setOnclickFunctions();


    document.getElementById('id-button-download').onclick = idButtonDownload_onclick;
}

function idButtonDownload_onclick()
{


    let arrPostRequest = {
        operation:      'startParsing',
        startingUrl:    document.getElementById('id-select-chapter').value
    };

    _sendPostRequest('index',arrPostRequest,postRequest_startParsing_OK);



}

function postRequest_startParsing_OK()
{
    //парсинг прошел успешно подкачнем, 1ю вкладку

    alert('Парсинг завершен');

    let arrPostRequest = {
        operation:  'getTab',
        tabNumber:  1
    };

    _sendPostRequest('index',arrPostRequest,postRequest_getTab_OK);

}

function setOnclickFunctions()
{
    _setOnclickByClass('js-pagination',pagination_onclick);
    _setOnclickByClass('js-button-see-full',buttonSeeFull_onclick);
}

////////////////////////////////////////////////
//
// клик по кнопке пагинатора
// запрашиваем через POST другую стрницу с 5ю првеью статей
//
function pagination_onclick()
{
    let arrPostRequest = {
        operation:  'getTab',
        tabNumber:  this.getAttribute('data-newtab')
    };

    _sendPostRequest('index',arrPostRequest,postRequest_getTab_OK);
}


function postRequest_getTab_OK(arrPostAnswer)
{
    document.getElementById('id-tab').innerHTML = arrPostAnswer['newTab'];

    //заново настроим обработчики кликов
    setOnclickFunctions();
}
/////////////////////////////////////////////////////////////////////

function buttonSeeFull_onclick()
{
    let arrPostRequest = {
        operation:  'getArticle',
        idArticle:  this.getAttribute('data-id-article')
    };

    _sendPostRequest('index',arrPostRequest,postRequest_getSeeFull_OK);
}



function postRequest_getSeeFull_OK(arrPostAnswer)
{

    document.getElementById('id-modal-article').innerHTML =
        "<div class='container column'>"
        + '<h2>' + arrPostAnswer['Article']['title'] + '</h2><br>'
        + arrPostAnswer['Article']['mainText']
        + '</div>';

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