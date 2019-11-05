<?php


namespace Core;


/**
 * инфтерфейс модели
 *
 * @package Core
 */
interface iModel
{

    /**
     * полностью возвращает все данные которые есть
     *
     * @return array
     */
    public function getData($params=[]):array;
}