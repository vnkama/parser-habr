<?php

namespace controllers;


class ArticlesController extends Controller
{
    /**
     * обработчик GET запросов, выхывается из роутера
     */
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

        //вернем поученный хтмл в браузер
        echo $html;
    }


    /**
     * обработчик POST запросов, выхывается из роутера
     */
    public function routePOST()
    {
        //получим данные из маccива POST
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

    /**
     *
     */
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


    /**
     *
     */
    private function handleGetArticle()
    {
        $model = new \models\ArticlesModel();
        $arr = $model->getArticle(['idArticle' => $this->getPostInt('idArticle')]);
        $this->arrPostAnswer = array_merge($this->arrPostAnswer,$arr);
    }


    private function handleStartParsing()
    {
        $model = new \models\ArticlesModel();
        $model->parsing(['startingUrl' => $this->getPostString('startingUrl')]);
        $this->arrPostAnswer = array_merge($this->arrPostAnswer,[]);
    }
}
