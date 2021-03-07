# 手撸 Laravel MVC 

## 第一步

我们来尝试下手动构建Laravel MVC

首先构建下我们的 `composer.json` 文件

```
{
  "require" :{
    "illuminate/routing" : "*",
    "illuminate/events" : "*",
    "illuminate/database" : "*",
    "illuminate/view" : "*"
  },
  "autoload" : {
    "psr-4" : {
      "App\\" : "app/"
    }
  }
}
```

可以看到我们使用了最基础的几个包，里面包含有路由、事件、数据库、视图等组件。

根据Laravel目录结构，还添加了PSR-4的自动加载规范，实现了**命令空间到目录的映射**



## 第二步

创建入口文件 `index.php` 添加如下内容

```
//调用自动加载函数文件，添加自动加载函数
require __DIR__ . '/../vendor/autoload.php';
//实例化服务容器
$app = new \Illuminate\Container\Container();
//注册事件，路由服务提供者
with(new \Illuminate\Events\EventServiceProvider($app))->register();
with(new \Illuminate\Routing\RoutingServiceProvider($app))->register();
//加载路由
require __DIR__ . '/../app/Http/routes.php';

//实例化请求 并分发处理请求
$request = \Illuminate\Http\Request::createFromGlobals();
$response = $app['router']->dispatch($request);

//返回请求响应
$response->send();
```

这里我们可以看到 Laravel 最核心的容器，服务容器用于服务注册和解析，也就是说向服务容器注册能够实现某些功能的实例或回调函数，当需要使用该功能时从服务容器中获取相应的实例来完成。



## 第三步

访问数据库， 我们要在 config目录下添加配置文件 `database.php`  然后在入口添加如下内容

```
//启动Eloquent ORM的模块并进行相关配置
use Illuminate\Database\Capsule\Manager;

$manager = new Manager();
$manager->addConnection(require '../config/database.php');
//Eloquent ORM的模块启动
$manager->bootEloquent();
```

由于我们使用 `Eloquent ORM` 所以需要使用到数据库管理类。 `Eloquent ORM` 操作数据库比较简单，分两个步骤，一是创建模型类、二是通过模型类的方法操作数据库。



## 第四步

最后我们来创建视图

```
//服务容器实例通过instance方法将名称为 config 和 \Illuminate\Support\Fluent类进行实例绑定
//Fluent类主要是存储视图模块的配置信息
$app->instance('config', new \Illuminate\Support\Fluent);
//将模块文件和编译文件的存储路径，添加到配置实例中
$app['config']['view.compiled'] = dirname(dirname(__FILE__)) . '/storage/framework/views';
$app['config']['view.paths']    = ['../resources/views/'];
```

`Fluent`类主要是存储视图模块的配置信息，我们通过`instance()` 方法 将服务名称为 `config` 和`Fluent`类的实例进程绑定。`compiled` 代表编译文件路径`paths` 代表视图模版文件路径

**最后**我们配置好`nginx`服务器 访问 `127.0.0.1/welcome` 就可以看到结果了，别忘记数据库信息配置自己服务器的。

大家可以自己动手感受下，完整代码地址 `https://github.com/H-pinke/Laravel_MVC`

