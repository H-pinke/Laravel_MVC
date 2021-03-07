<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Container;

class WelcomeController
{

    public function index() {
        //return "<h1>访问到达了控制器</h1>";
        $users  = User::first();
        $data = $users->getAttributes();

        $app = Container::getInstance();
        $factory = $app->make('view');
       // var_dump($factory->make('welcome'));die;
        return $factory->make('welcome')->with('data', $data);

        //var_dump($data);
    }
}