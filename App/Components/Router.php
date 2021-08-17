<?php
/**
 * Самый простой роутер
 */

namespace App\Components;

use App\Controllers\SiteController;

class Router {

    /**
     * start app
     */
    public function run() :void
    {

        $controller = new SiteController();
        $method = strtoupper($_SERVER['REQUEST_METHOD']);
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if($method == 'GET' && $requestUri == '/') {
            $controller->index();
        }

        if($method == 'GET' && $requestUri == '/getComments') {
            $controller->getComments();
        }

        if($method == 'POST') {
            $controller->addComment();
        }
    }
}
