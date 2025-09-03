<?php
namespace App\Core;

class App {
    private $router;
    private $request;

    public function __construct() {
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

public function run() {
    // تعريف المسارات
    $this->router->get('', 'HomeController@index');
    $this->router->get('home/index', 'HomeController@index');
    $this->router->get('auth/login', 'AuthController@login');
    $this->router->post('auth/login', 'AuthController@authenticate');
    $this->router->get('auth/register', 'AuthController@register');
    $this->router->post('auth/register', 'AuthController@store');
    $this->router->get('auth/logout', 'AuthController@logout'); // تغيير من POST إلى GET
    $this->router->get('users/index', 'UsersController@index');

    // توجيه الطلب
    $this->router->dispatch();
}
}
?>