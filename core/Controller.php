<?php

namespace Core;

use \Error;



class Controller
{
    protected $model;
    protected $view;

    protected $arrPostRequest;  //запрос
    protected $arrPostAnswer;   //ответ на post запрос браузера


    protected $data2View=[];    //массив данных для передачи во view.


    protected $isAdmin;



    /**
     * Самый простейшйи обрабочтик запроса, просто полностью показывает статический файл
     * никаких шаблонов, никаких парметров !!
     *
     * можно прямо из routes.php вызывать
     *
     * @param $htmlFile
     */
/*    public function routeHtml($htmlFile)
    {
        require_once ($htmlFile);
    }*/



    /**
     *
     * @param $params
     */
/*    public function routeView($toView)
    {
        require_once ($toView['templateFile']);
    }*/


    /**
     * Обрабочтки запроса.
     *
     * Модель не используем, показываем view с параметрами
     *
     * @param $viewFile
     */
/*    public function runView($viewFile='template.html',$toView=[])
    {
        $toView = $this->data2View;
        require_once ($viewFile);
    }*/


    public function runModelView($classModel,$funcModel=null,$paramsModel=null,$classView=null,$funcView=null,$paramsView=null)
    {
        $funcModel  = ($funcModel) ?? 'getData';
        $funcView   = ($funcView) ?? 'createHtml';

        $classModelName = "\\models\\$classModel";
        $this->model = new $classModelName();
        $toView = $this->model->$funcModel($paramsModel);
        $toView = array_merge($toView,$this->data2View);


        $classViewName = "\\views\\$classView";
        $this->view = new $classViewName();

        echo $this->view->$funcView($paramsView,$toView);
    }


    public function runPostRequest($classModel,$modelParams)
    {
        $this->model = new $classModel($modelParams);

        $this->arrPostAnswer = $this->model->getAll();

        echo json_encode($this->arrPostAnswer);
    }


    protected function getDataFromPostRequest()
    {
        if (!isset($_POST['jsonPostRequest'])) throw new Error();

        $this->arrPostRequest = json_decode($_POST['jsonPostRequest'],true);
    }

    protected function sendPostAnswer()
    {
        $this->arrPostAnswer['errorMessage']		= 'OK';
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
        if (!isset($this->arrPostRequest[$paramName]) ) throw new Error('post_error');

        $len = strlen($this->arrPostRequest[$paramName]);
        if ($len <1 || $len > $maxLen)  throw new Error('post_error');

        return (string)$this->arrPostRequest[$paramName];
    }

/*    protected function getPostDatetime($paramName)
    {
        //проверка на корректность
        if (!isset($_POST[$paramName]) ) throw new Exception('post_error');

        if (strlen($_POST[$paramName]) != 19) throw new Exception('post_error');

        //проверка регуляркой
        if (!preg_match('#^\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d$#',$_POST[$paramName])) throw new Exception('post_error');

        return (string)$_POST[$paramName];
    }*/

/*    public function runM($bundleName)
    {
        $bundleName = 'App\Bundles\\'.$bundleName;
        $this->Bundle = new $bundleName();
        $arrBundleData = $this->Bundle->getAll(); //дянные из модели

        return $arrBundleData;
    }

    public function runMV($bundleName,$viewName,array $paramsBundle=null)
    {
        $bundleName = 'App\Bundles\\'.$bundleName;

        $this->Bundle = new $bundleName($paramsBundle);

        $arrBlade = $this->Bundle->getAll();    //данные из модели

        return view($viewName,$arrBlade);
    }*/
}
