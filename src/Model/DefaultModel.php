<?php

namespace App\Model;


use App\Component\Router;


class DefaultModel
{
    public function getLinks()
    {
        return Router::getRoutes();
    }
}