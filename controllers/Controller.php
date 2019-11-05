<?php

namespace controllers;

use \Error;



class Controller
{
    protected $model;
    protected $view;

    protected $html;

    protected $arrPostRequest=[];  //запрос
    protected $arrPostAnswer=[];   //ответ на post запрос браузера


    protected $data2View=[];    //массив данных для передачи во view.




    /**
     *
     */
    public function runModelView($classModel,$funcModel=null,$paramsModel=null,$classView=null,$funcView=null,$paramsView=null)
    {
        $funcModel  = ($funcModel) ?? 'getData';
        $funcView   = ($funcView) ?? 'createHtml';

        $classModelName = "\\models\\$classModel";
        $this->model = new $classModelName();
        $this->data2View = $this->model->$funcModel($paramsModel);


        $classViewName = "\\views\\$classView";
        $this->view = new $classViewName();

        return $this->view->$funcView($paramsView,$this->data2View);
    }


    /**
     * декодируем забираем данные полученые от браузера в  $_POST
     *
     *
     * результат в массив $this->arrPostRequest
     */
    protected function getDataFromPostRequest()
    {
        if (!isset($_POST['jsonPostRequest'])) throw new Error();

        $this->arrPostRequest = json_decode($_POST['jsonPostRequest'],true);

    }

    /**
     * отправляем ответ на пост запрос
     * данные должны быть готовы в $this->arrPostAnswer
     *
     */
    protected function sendPostAnswer($errorMessage = 'OK')
    {
        $this->arrPostAnswer['errorMessage']		= $errorMessage;
        echo json_encode($this->arrPostAnswer);		//вывод массива результата
    }

    /**
     * возвращает название операции из POST запроса
     *
     * @return mixed
     */
    protected function getPostOperation()
    {
        //проверка на корректность
        if (!isset($this->arrPostRequest['operation']) ) throw new Error('post_error');

        $len = strlen($this->arrPostRequest['operation']);
        if ($len <3 || $len > MAX_STRLEN)  throw new Error('post_error');

        //все ОК вернем операцию
        return $this->arrPostRequest['operation'];
    }


    /**
     * применеяется при обратке пост запроса
     * проверяет наличие парметра и возвращает его
     * даннее запроса берем из $this->arrPostRequest
     * тип данных - int
     * проверяет наличие парметра и возвращает его
     *
     * @param $paramName -
     *
     * @return int
     */
    protected function getPostInt($paramName)
    {
        //проверка на корректность
        if (!isset($this->arrPostRequest[$paramName]) ) throw new Error('post_error');

        $len = strlen($this->arrPostRequest[$paramName]);
        if ($len <1 || $len > 11)  throw new Error('post_error');

        //проверка регуляркой
        if (!preg_match('#^-?[\d]{1,10}$#',$this->arrPostRequest[$paramName])) throw new Error('post_error');

        return (int)$this->arrPostRequest[$paramName];
    }

    protected function getPostString($paramName,$maxLen = MAX_STRLEN)
    {
        //проверка на корректность
        if (!isset($this->arrPostRequest[$paramName]) ) throw new Error($paramName);

        $len = strlen($this->arrPostRequest[$paramName]);
        if ($len <1 || $len > $maxLen)  throw new Error('post_error');

        return (string)$this->arrPostRequest[$paramName];
    }

    /**
     * обрабочтк вызвается роутером при ошибке 404
     * просто выводит хтмл
     */
    public function route404()
    {
        $toView['title']       = 'Комментарии';
        $toView['body_html']   = '404.html';
        include '../views/template.html';
    }
}
