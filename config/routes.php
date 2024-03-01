<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;
use Middleware\Validator\TransactionMiddleware;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');


Router::addGroup('/user', function () {
    Router::post('/create', 'App\Controller\UserController::createUser');
});

Router::addGroup(
    '/tranfer',
    function () {
        Router::post('/create', 'App\Controller\TransferController::createTransfer');
    },
    ['middleware' => [TransactionMiddleware::class]]
);

Router::addGroup('/wallet', function () {
    Router::post('/create', 'App\Controller\WalletController::createBalance');
});

Router::get('/favicon.ico', function () {
    return '';
});
