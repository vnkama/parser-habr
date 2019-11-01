<?php


namespace models;



class ArticlesModel implements \core\iModel
{
//    protected $arrArticles; //все комменты для показа

/*    public function __construct()
    {

    }*/


/*    public function getData($params=[]):array
    {
        $arrRes=[];
        if (!count($params)) {
            $arrRes['Articles'] =  sql()->select("select idArticle,title,left(mainText,200) as mainText from Articles where 1 limit 5");
            $arrRes['countArticles'] = count($arrRes['Articles']);
            return $arrRes;
        }

        else {
            throw new \Error();
        }
    }*/

    public function getData($params=[]):array
    {

        $arrRes['countArticles'] = sql()->selectValue("select count(*)from Articles where 1");


        $offset = ($params['pageNumber']-1) * 5;    //pageNumber 1-based
        $q = "select idArticle,title,left(mainText,200) as mainText from Articles where 1 order by created,idArticle limit 5 offset $offset";
        $arrRes['Articles'] =  sql()->select($q);

        return $arrRes;
    }

}
