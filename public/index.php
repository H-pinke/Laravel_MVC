<?php
ini_set("display_errors", 1);
use Illuminate\Database\Capsule\Manager;
//调用自动加载函数文件，添加自动加载函数
require __DIR__ . '/../vendor/autoload.php';

//实例化服务容器
$app = new \Illuminate\Container\Container();

//将服务容器添加为静态属性，这样可以在任何地方获取服务容器的实例
\Illuminate\Container\Container::setInstance($app);

//注册事件，路由服务提供者
with(new \Illuminate\Events\EventServiceProvider($app))->register();
with(new \Illuminate\Routing\RoutingServiceProvider($app))->register();

//启动Eloquent ORM的模块并进行相关配置
$manager = new Manager();
$manager->addConnection(require '../config/database.php');
//Eloquent ORM的模块启动
$manager->bootEloquent();

//服务容器实例通过instance方法将名称为 config 和 \Illuminate\Support\Fluent类进行实例绑定
//Fluent类主要是存储视图模块的配置信息
$app->instance('config', new \Illuminate\Support\Fluent);
//将模块文件和编译文件的存储路径，添加到配置实例中
$app['config']['view.compiled'] = dirname(dirname(__FILE__)) . '/storage/framework/views';
$app['config']['view.paths']    = ['../resources/views/'];

//注册 文件，视图的服务提供者
with(new \Illuminate\View\ViewServiceProvider($app))->register();
with(new \Illuminate\Filesystem\FilesystemServiceProvider($app))->register();
//加载路由
require __DIR__ . '/../app/Http/routes.php';

//实例化请求 并分发处理请求
$request = \Illuminate\Http\Request::createFromGlobals();
$response = $app['router']->dispatch($request);

//返回请求响应
$response->send();

