<?php
    //массив роутов
    return [

        ['type' => 'get',   'routeName' => 'index',   'Controller' => 'ArticlesController',    'func' => 'routeGET'],
        ['type' => 'post',  'routeName' => 'index',   'Controller' => 'ArticlesController',    'func' => 'routePOST'],

        ['type' => 'get',   'routeName' => 'page404', 'Controller' => 'Controller',            'func' => 'route404'],

    ];
