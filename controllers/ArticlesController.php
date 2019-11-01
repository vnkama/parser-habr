<?php

namespace controllers;


class ArticlesController extends \core\Controller
{

    public function routeGET()
    {
        $pageNumber = 1;    //начнем с первой страницы

        $this->data2View['pageNumber'] = $pageNumber;


        $this->runModelView(
            'ArticlesModel',
            null,
            ['pageNumber' => $pageNumber],

            'ArticlesListView',
            'createHtml_TotalPage',
            null);
    }

    public function routePOST()
    {
        //получим данные из маиисва POST
        $this->getDataFromPostRequest();



        switch ($this->getPostOperation()) {
            case 'requestPreviews':
                $this->handleRequestPreviews();
                break;

            case 'requestArticle':
                $this->handleRequestArticle();
                break;

            case 'startParsing':
                $this->handleStartParsing();
                break;

            default:
                //неизвестная операция
                throw new \Exception();
                break;
        }

        $this->sendPostAnswer();
    }

    private function handleRequestPreviews()
    {
        $pageNumber = $this->getPostInt('pageNumber');

        $this->runModelView(
            'ArticlesModel',
            null,
            ['pageNumber' => $pageNumber],

            'ArticlesListView',
            'createHtml_Previews',
            null);

    }


    private function handleRequestArticle()
    {

    }


    private function handleStartParsing()
    {

    }

}
