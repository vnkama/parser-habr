<?php


namespace views;



class ArticlesListView extends \core\View
{
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

    public function createHtml_Tab($params,$toView)
    {

        $tabNumber = $params['tabNumber'];    //номер текущей страницы, которую показываем
        $tabsCount = (int)(($toView['countArticles']-1) / 5) + 1;     //всего кол-во страниц

        $isPagination= ($tabsCount >=2);
        $minShowTabNum = max($tabNumber-2,1);
        $maxShowTabNum = min($tabNumber+2,$tabsCount);

        $itemFirstDisabled = ($tabNumber == 1);
        $itemLastDisabled = ($tabNumber == $tabsCount);

        ob_start();
        include 'ArticlesList_Block_Tab.html';
        return ob_get_clean();
    }

}