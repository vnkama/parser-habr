<?php


namespace models;

include 'simple_html_dom.php';





class ArticlesModel implements \core\iModel
{

    public function getData($params=[]):array
    {

        $arrRes['countArticles'] = sql()->selectValue("select count(*)from Articles where 1");


        $offset = ($params['tabNumber']-1) * 5;    //tabNumber 1-based
        $q = "select idArticle,title,url,previewText from Articles where 1 order by created,idArticle limit 5 offset $offset";
        $arrRes['Articles'] =  sql()->select($q);

        return $arrRes;
    }

    public function getArticle($params)
    {
        $arrRes['Article'] =  sql()->selectRecord("select title,mainText from Articles where idArticle=${params['idArticle']}");

        return $arrRes;
    }




    public function parsing($params)
    {
        $url = 'https://habr.com'.$params['startingUrl'];
        logout("ыы parsingDOM url: $url");

        $html =  str_get_html($this->curl_getPage($url));


        //все ссылки на страницы. обычо ссылок около 10-20. но нам буудт нужны первые 5, которых еще нет
        $arrPages = $html->find('a.post__title_link');


        $parsedPages = 0;

        // цикл
        foreach ($arrPages as $arrPage) {

            $url = $arrPage->href;
            logout("проверка страницы url: $url, parsedPages $parsedPages");

            if (substr($url,0,16) !== 'https://habr.com') continue;
            $shortUrl = substr($url,16); //уберем домен из адреса, тк в БД храним без домена

            //проверим есть ли такйо url уже в базе
            //если еть - на выход
            $count = sql()->selectValue("select count(*) from Articles where url = '$shortUrl' ");
            if ($count) continue;

            //скачаем файл
            $html =  str_get_html($this->curl_getPage($url));

            //ищем заголовок
            $arrTitles = $html->find('span.post__title-text');

            //ищем основной текст
            $arrBlobs = $html->find('div.post__text-html');

            //классы post__title-text и post__text-html должны быть уникальны на старнице
            if (count($arrBlobs) !== 1 || count($arrTitles) !== 1 ) continue;

            logout("запишем url: $url");

            $title      = sql()->escape($arrTitles[0]->plaintext);
            $mainText   = sql()->escape($arrBlobs[0]->innertext);
            $previewText   = sql()->escape(mb_substr($arrBlobs[0]->plaintext,0,200));

            $q = "insert into Articles (title,url,mainText,previewText) values ('$title','$shortUrl','$mainText','$previewText')";
            sql()->insert($q);
            logout("sql insert ok");

            //если уже 5 тарниц спарсили то завершаем цикл
            if (++$parsedPages >= 3) break;
            logout("parsedPages $parsedPages");
        }
    }

    /**
     * @param $url
     *
     * @return bool|string
     */
    private function curl_getPage($url)
    {
        $ch = curl_init();
        curl_setopt_array($ch,[CURLOPT_URL => $url,CURLOPT_RETURNTRANSFER => 1,CURLOPT_HEADER => 0]);
        $html = curl_exec($ch);
        curl_close($ch);

        $html= mb_convert_encoding($html, UTF8, mb_detect_encoding($html));

        return $html;
    }


}
