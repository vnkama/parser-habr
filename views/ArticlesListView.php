<?php


namespace views;



class ArticlesListView extends \core\View
{
    /**
     * генериреут хтмл код для главной
     *
     * @param $params   массив параметров
     *                  $params['tabNumber'] - номер вкладки
     * @param $toView
     *
     * @return false|string     возвращаем хтмл страницы
     */
    public function createHtml_TotalPage($params,$toView)
    {
        $toView['title']       = 'Комментарии';
        $toView['body_html']   = 'ArticlesList.html';
        $toView['body_class']  = 'page01';
        $toView['script_file'] = 'ArticlesList.js';

        $toView['div_tab_innerHTML']     = $this->createHtml_Tab($params,$toView);

        ob_start();
        include 'template.html';
        return ob_get_clean();
    }

    /**
     * генерирует хтмл код для 5 превью статей и пагинатора
     *
     * @param $params
     *                  $params['tabNumber']    - номер текущей вкладки, которую показываем (1-based)
     *
     * @param $toView - данные ля вывода во вью, используются в хтмл шаблоне
     *
     * @return false|string
     */
    public function createHtml_Tab($params,$toView)
    {

        //расчитаем параметры для пагинатора
        $tabNumber = $params['tabNumber'];
        $tabsCount = (int)(($toView['countArticles']-1) / 5) + 1;     //всего кол-во страниц

        $isPagination= ($tabsCount >=2);    //пагинация включается от двух вкладок
        $minShowTabNum = max(min($tabNumber-2,$tabsCount-4),1);   //первый(левый) видимый номер на пиагинаторе
        $maxShowTabNum = min(max($tabNumber+2,5),$tabsCount);           //последний (правый) видимый номер на пагинаторе

        $itemFirstDisabled = ($tabNumber == 1);     //true - отключить кнопки "влево", т.к. итак показываем первую вкладку
        $itemLastDisabled = ($tabNumber == $tabsCount);     // отклбючить кнопки "вправо" т.к. показываем последнюю вкладку

        //подключаем хтмл шаблон вклдки и пагинатора
        ob_start();
        include 'ArticlesList_Block_Tab.html';
        return ob_get_clean();
    }

}