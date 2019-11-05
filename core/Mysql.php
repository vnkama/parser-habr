<?php 
namespace core;

use \Error;





/**
 * Class Mysql
 *
 * класс - прокладка для доступа к mysql
 *
 *
 */
class Mysql
{ 
	private $dblink;

    public function __construct($config)
    {

        $this->dblink = mysqli_connect(
            'localhost',
            $config['username'],
            $config['password'],
            $config['database']
        );

        if (!$this->dblink) throw new Error();


        if (!mysqli_select_db($this->dblink, $config['database']))  throw new Error();

        // указывать кодировку нужно втч для mysqli_real_escape_string
        if (!mysqli_set_charset($this->dblink, 'utf8mb4')) throw new Error();
    }


    /**
     * фунцкия используется для INSERT
     *
     * @param $q        полный текст запросатипа: insert into ...
     *
     *
     */
    public function insert($q)
    {
        if (!mysqli_query($this->dblink, $q)) throw new Error($q);
    }


    /**
     * @param $q        полный текст запроса типа: select into ...
     * @return mixed
     *
     *функция вызывается когда запрос должен вернуть СТРОГО только одно значение или одно . например запрос типа: select count(*) from ...
     *
     * если рядов  в ответе несколько вызовет ошибку
     */
    public function selectValue($q)
    {

        $mysql_result=mysqli_query($this->dblink, $q);

        if (!$mysql_result)  throw new Error();

        $arrRow=mysqli_fetch_array($mysql_result,MYSQLI_NUM);

        if (!$arrRow || count($arrRow) != 1)  throw new Error();

        mysqli_free_result($mysql_result);

        return $arrRow[0];
    }

    /**
     * @param $q -строка запроса
     * @return array|null
     *
     * возвращает только одну строку результата !!!
     * если несколько строк то это ошибка
     * если ответа нет - это ошибка
     * возвращает ОДНОМЕРНЫЙ ассоциативный масиив если ответ есть
     * формат массива $arrRows['fieldName']
     *
     */
    public function selectRecord($q)
    {
        $mysql_result=mysqli_query($this->dblink, $q);
        if (!$mysql_result)  throw new Error($q);
        $arrRes=[];

        if (mysqli_num_rows($mysql_result) == 1) {
            $arrRow = mysqli_fetch_assoc($mysql_result);	//$arrRow 1-мерный массив
            if (!$arrRow || !count($arrRow))  throw new Error($q);
        }
        else {
            //в функции может быть в ответе только
            throw new Error();
        }

        mysqli_free_result($mysql_result);

        return $arrRow;
    }


    /**
     * отрабатыват запрос select
     *
     * @param $q -строка запроса
     *
     * @return array
     * возвращает [] если запрос пустой
     * возвращает двумерный ассоциативный масиив если ответ есть
     * формат массива $arrRows[номер row 0-based]['fieldName']
     *
     */
    public function select($q)
    {

        $mysql_result=mysqli_query($this->dblink, $q);
        if  (!$mysql_result) throw new Error($q);

        $arrRows = [];
        while ($row = mysqli_fetch_assoc($mysql_result)) {
            $arrRows[]=$row;
        }

        mysqli_free_result($mysql_result);

        return $arrRows;
    }

    /**
     * просто вызов  mysqli_real_escape_string
     */
    public function escape_string($str)
    {
        return mysqli_real_escape_string($this->dblink,$str);
    }
}
