<?php

return [
    'default' => [
        'pattern' => '/',
        'controller' => \App\Controller\DefaultController::class,
        'action' => 'default',
    ],
    'test1' => [
        'pattern' => '/Test-1',
        'controller' => \App\Controller\TestController::class,
        'action' => 'tag',
    ],
    'test2' => [
        'pattern' => '/Test-2',
        'controller' => \App\Controller\TestController::class,
        'action' => 'key',
    ],
    'test3' => [
        'pattern' => '/Test-3',
        'controller' => \App\Controller\AdjacencyListController::class,
        'action' => 'showTree',
    ],
    'test4' => [
        'pattern' => '/Test-4',
        'controller' => \App\Controller\AdjacencyListController::class,
        'action' => 'showParents',
    ],
    'test5' => [
        'pattern' => '/Test-5',
        'controller' => \App\Controller\AdjacencyListController::class,
        'action' => 'showChildren',
    ],
    'test6' => [
        'pattern' => '/Test-6',
        'controller' => \App\Controller\TestController::class,
        'action' => 'showClones',
    ],
    'test7' => [
        'pattern' => '/Test-7',
        'controller' => \App\Controller\TestController::class,
        'action' => 'showCombinations',
    ],
    'comment_list' => [
        'pattern' => '/comment/list',
        'controller' => \App\Controller\CommentController::class,
        'action' => 'list',
    ],
    'comment_add' => [
        'pattern' => '/comment/add',
        'controller' => \App\Controller\CommentController::class,
        'action' => 'add',
    ],
    'comment_answer' => [
        'pattern' => '/comment/(?P<idi>\d+)/answer',
        'controller' => \App\Controller\CommentController::class,
        'action' => 'answer',
    ],
    'comment_edit' => [
        'pattern' => '/comment/(?P<idi>\d+)/edit',
        'controller' => \App\Controller\CommentController::class,
        'action' => 'edit',
    ],
    'comment_delete' => [
        'pattern' => '/comment/(?P<idi>\d+)/delete',
        'controller' => \App\Controller\CommentController::class,
        'action' => 'delete',
    ],
];
