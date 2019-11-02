<?php


namespace models;



class ArticlesModel implements \core\iModel
{


    public function getData($params=[]):array
    {

        $arrRes['countArticles'] = sql()->selectValue("select count(*)from Articles where 1");


        $offset = ($params['tabNumber']-1) * 5;    //tabNumber 1-based
        $q = "select idArticle,title,left(mainText,200) as mainText from Articles where 1 order by created,idArticle limit 5 offset $offset";
        $arrRes['Articles'] =  sql()->select($q);

        return $arrRes;
    }

}
