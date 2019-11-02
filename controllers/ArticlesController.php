<?php

namespace controllers;


class ArticlesController extends \core\Controller
{

    public function routeGET()
    {
        $tabNumber = 1;    //начнем с первой страницы

        $this->data2View['tabNumber'] = $tabNumber;


        $html = $this->runModelView(
            'ArticlesModel',
            null,
            ['tabNumber' => $tabNumber],

            'ArticlesListView',
            'createHtml_TotalPage',
            ['tabNumber' => $tabNumber]);


        echo $html;
    }

    public function routePOST()
    {
        //получим данные из маиисва POST
        $this->getDataFromPostRequest();



        switch ($this->getPostOperation()) {
            case 'getTab':
                $this->handleGetTab();
                break;

            case 'getArticle':
                $this->handleGetArticle();
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

    private function handleGetTab()
    {
        $tabNumber = $this->getPostInt('tabNumber');

        $this->arrPostAnswer['newTab'] = $this->runModelView(
                                            'ArticlesModel',
                                            null,
                                            ['tabNumber' => $tabNumber],

                                            'ArticlesListView',
                                            'createHtml_Tab',
                                            ['tabNumber' => $tabNumber]
                                        );
    }


    private function handleGetArticle()
    {
        $idArticle = $this->getPostInt('idArticle');

    }


    private function handleStartParsing()
    {

    }

}
