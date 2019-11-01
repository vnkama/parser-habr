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

        $toView['div_previews']     = $this->createHtml_Previews($params,$toView);

        return require 'template.html';
    }

    public function createHtml_Previews($params,$toView)
    {
        $pageNumber = $toView['pageNumber'];    //номер текущей страницы, которую показываем
        $pagesCount = (int)(($toView['countArticles']-1) / 5) + 1;     //всего кол-во страниц

        $isPagination= ($pagesCount >=2);
        $minShowPageNum = max($pageNumber-2,1);
        $maxShowPageNum = min($pageNumber+2,$pagesCount);

        $itemFirstDisabled = ($pageNumber == 1);
        $itemLastDisabled = ($pageNumber == $pagesCount);

        ob_start();
        include 'ArticlesList_Previews.html';
        return ob_get_clean();
    }

}