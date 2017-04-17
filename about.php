
1.前期配置
2.管理员模块
3.会员模块
4.商品分类模块
5.商品模块
6.前台首页
  商品详情
  购物车模块
7.订单模块
8.支付模块
9.订单发货
10.Assets前端资源
11.用户认证体系
12.RBAC
13.es全文搜索
14.redis异步发邮件
15.缓存机制
16.url美化处理
17.Sentry日志收集
18.mysql架构
19.lvs均衡负载

一：前期配置
    1. test控制器下面test方法：http://www.yii2.com/index.php?r=test/test
    2.模型与表名相同
        public static function tableName()
        {
            return "{{%product}}";
        }
    3.传递过去model是一个对象
    4.后台模块
        a.配置文件web.php开启gii
        b.页面访问index.php?r=gii  Module Generator         app\modules\admin   admin
        c.创建新的Module  admin
        d. www.yii2.comindex.php?r=admin/default/index  访问后台模块
    5.  vendor/yiisoft/yii2/web/Application.php
        修改web.php  config 默认访问    'defaultRoute' => 'index',
二：管理员模块  控制器（Public）   模型（Admin）
    （http://www.yii2.com/admin/public/login） （http://www.yii2.com/index.php?r=admin/public/login）
    1.管理员登录  public/login
        a.创建数据表,修改db.php里面配置
        b.public/login 加载登录页面public/login.php
        c.在Admin模型里面写规则 admin/login(进行验证) validatePass(验证用户名和密码是否匹配)
        d.  ************如果已经登录,不显示登录页面
    2.邮件找回密码 public/Seekpassword
        a.web.php mailer类
        b.  调用 admin/seekPass 完成邮件发送 ,调用createToken(),生成令牌
            在规则里加入validatemail验证用户名和邮箱是否匹配, 并实现这个方法
        c.点击链接,跳转到manage/mailchangepass             (这里不需要登录)
        d.验证通过 模型 admin/changePass (实现密码修改)

    3.管理员列表(分页) manage/manages
        Url::to 产生相对路径

    4.添加管理员 manage/reg
        a.在config/params 下面配置每页条数
    5.删除管理员 manage/del
    6.管理员修改邮箱 manage/changeemail
        调用 模型admin/changeEmail方法
    7.管理员修改面 manage/changepass
三：用户管理模块 控制器（user/member） 模型(user)
    1.添加新用户 user/reg  模型user/reg
    2.用户列表(分页) user/users
        a.联表查询(表profile)
        b.config/params 里面有头像默认值
    3.用户列表删除(事务) user/del
    4.前台用户登录 member/auth  user/login
    5.前台用户注册(邮箱注册) member/reg  user/regByMail
    6.前台退出登录 member/logout
    7.qq登录 member/qqlogin
        a.www.sxlzrc.com  将域名解析到hosts
        b.var_dump($model->getErrors());
四：商品分类模块 控制器(category) 模型(category)
    1.传统分类 数据表多,难扩展,表间关联性强
    2.无限分类 id title parentid
    3. 添加商品分类 category/add   模型category/add   每个管理员只能删除修改他自己添加分类
        category/getData 查询分类到添加页面
        category/setPrefix 给分类添加标识
    4. 商品分类列表 category/list       category/getPrimaryCate
    5. 商品分类编辑
    6. 商品分类删除
五.商品模块 控制器(product) 模型(product)
    1.商品添加(七牛上传)
    2.商品列表
    3.商品编辑
    4.商品上下架
六.
    A.前台首页 控制器index
        1.商品菜单
            common控制器里面init方法 $this->view->params['menu'] 这样可以在layouts获取数据
        2.index控制器
            a.查询缓存  product模型
                （hot热卖 tui推荐 Promotion促销）

                最新商品 new
                促销商品 sale
                热卖商品 hot
                推荐商品 tui
                奢侈品 luxury
            b.picture模型查询出四张广告图
            c. 模型 category/getMenu  (限制：8个父级分类,十个子级份额里)
        3.在common控制器里面得到模板上显示商品分类(限制8个)
    B.商品分类详情  product/index
        1.查询出当前分类  推荐，热卖，促销，全部商品
      商品详情页    product/detail
    C.购物车    控制器cart
        1.商品详情页加入购物车 post提交（商品id,数量,价格,用户id）
            $userid = Yii::$app->user->id;  用户认证体系获取用户id
            \Yii::$app->user->identity->username  获取用户名
        2.列表页加入购物车  get提交
        3.有购物车就更新数量,没有就创建购物车
        4.购物车数量和价格同步
        5.购物车修改 cart/mod
           a.js:商品详情页  ->script.js页面
           b.购物车页面 ->js  页面下面
        6.删除 cart/del
七：订单模块
    （点击结算进入order/add(清空购物车)->订单页面order/check）(保存下单人,订单状态,商品信息,下单时间)
    (点击确认订单进入 order/confirm)(地址id,总价,订单状态,快递id)
    1.订单表和订单详情表关联
    2.添加订单 order/add
    3.查询订单下用户信息，订单详情,快递信息order/check
    4.添加收货地址 address/add    收货地址id通过隐藏域传递
    5.删除收货地址 address/del
    6.如果没有填写收货地址
八：支付模块
    点击确认订单 (http://www.sxlzrc.com/order/pay?orderid=6&paymethod=alipay)
    order/confirm ->
    1. order/pay -> 跳转到支付网关 ->
    pay/return (显示支付状态)
    ->notify.php(异步通知)
    ->pay/notify(更新订单状态)

八-1：order/check->order/index

九：订单发货和快递
    1.订单列表 order/list  模型order/details获取订单列表
    2.订单详情 order/detail  模型里面 order/getData 获取订单详细信息
    3.发货 order/send
    4.查看物流
十：用户认证体系rbac
十一：ES
十二：redis
十三：缓存
十四：URL美化
十五：Sentry日志


第二部分
    1. yii2框架Assets前端资源发布
    2.yii2框架用户认证体系
    3.yii2框架RBAC
    4.基于Elasticsearch实现商品全文搜索
    5.基于redis邮件异步发送工具
    6.yii2缓存机制和url美化处理
    7.yii2文件日志和Sentry日志收集以及Kafka消息队列使用
    8.高性能mysql架构
    9.LVS负载均衡实现高可用高性能服务器集群架构

    DBA->运维->架构师

    tips: 1.ctrl+alt+O清除不需要命名空间
预备：
安装composer
    1.composer global require "fxp/composer-asset-plugin:^1.2.0"
    2.composer create-project yiisoft/yii2-app-basic basic ^2.1.0
    3.php composer.phar create-project --prefer-dist --stability=dev yiisoft/yii2-app-basic basic
一 ：
    资源管理 ：（AppAsset.php 和site下面index.php）  后续资源放在web目录下
    1.默认访问  view/site/index.php
    views/layouts/main.php  AppAsset就是一个类

    2.按需加载 ：registerJsFile :加载js文件
                registerCssFile :加载css文件
                registerJs ：加载js代码
                registerCss :加载css代码

    3.优点：
        解决资源间依赖
        一键安装前端插件
        管理方便

        前端 资源开始 ：web/assets/下   -> web/下面    后端资源 ：

        1.将css/js全部放到assets/AppAssets.php
        2.在layout1.php 页面注册(use app\assets\AppAsset;) ,在配置文件config/web.php添加语言,字符集
        3.把assets目录下面css/js/images放到web目录下
        4. 把assets/images/替换为images/
        5.注册标题，meta标签，在index.php定义title
        6.将layouts页面js分别在对应页面注册  $this->registerJs($js);
          (order/check,order/index,cart/index,)
        7.替换nav导航
        后台资源 web/assets/admin下 -》web/admin下面
        1.复制appasset.php->AdminAsset.php  加载资源包
        2.在后台layouts中使用
        3.更换图片链接，在各个文件注册js
        后台登录 web/assets/admin下 -》web/admin下面
        引入两个文件
        use yii\helpers\Html;
        use app\assets\AdminLoginAsset;


    1.面包屑导航
        将<div class="content">提取出来到layout1   layout1 引入面包屑 在对应页面定义

        商品分类列表 (jstree)
        1.换源 ： composer config -g repo.packagist composer https://packagist.phpcomposer.com
        2.composer global require "fxp/composer-asset-plugin"  这是关键
        3.composer require --prefer-dist yii-dream-team/yii2-jstree "*" -vvv.
          （https://github.com/yii-dream-team/yii2-jstree）
        4.在category控制器里面tree(方法) 调用category模型getPrimaryCate(方法) 获取数据
        5.在category控制器里面list方法，返回分页数据
        这里点击分页没效果 : 因为模板里始终调用tree方法,
        解决 ： 在list方法定义$page接收页数$perpage传递给模板，在传递给tree方法
        6.对分类进行编辑和删除
        在页面 通过ajax修改 在控制器里面 rename(方法) 控制器里面定义场景

        文件使用压缩文件
        config/web.php 添加assetManager
        入口文件dev => prod  使用压缩文件

    二 ：用户认证体系 (用户名或电子邮件地址和一个加密令牌)
        1.设置用户组间yii\web\User; (管理用户认证状态)
            创建类User实现yii\web\IdentityInterface接口
            yii]web\IdentityInterface::findIdentity(); 根据用户id查找认证类实例
            yii\web\IdentityInterface::findIdentityByAccessToken(); 根据accesstoken获取用户认证值
            yii\web\IdentityInterface::getId()  获取用户实例id
            yii\web\IdentityInterface::validateAuthKey() 获取基于登录时秘钥

        2.在配置项web.php 有关于user配置
        3.identity  :  Yii::$app->user->identity;  // 当前用户身份实例,未认证用户为null
            id      :  Yii::$app->user->id;         // 当前用户主键id,未认证用户为null
            isGuest    :  Yii::$app->user->isGuest();  // 判断用户是否为游客
            方法 login      : 将当前用户身份登记到yii\web\user  属性 ：enableSession enableAutoLogin(自动登录)
            logout     : 注销用户 ，启用session时注销用户才有意义  logout(true) logout(false)

        4.更改登录方式
            之前登录 ：MemberController/auth(方法)  models/User模型
            user.php模型继承类并且继承接口  并实现五个方法
            重写User模型里面login方法和
            然后修改前端layouts1和2 \Yii::$app->session['isLogin'] => \Yii::$app->user->isGuest
            \Yii::$app->session['loginname']  => \Yii::$app->user->identity->username(获取用户名)
            \Yii::$app->user->identity->id  (获取用户id)

            用户退出，重写MemberController里面logout方法
        5.前台用户未登录设置禁止访问页面(order) 更改页面未登录限制访问方式
            a.在common控制器里面写behaviors(方法) ,在每个继承控制器里面写一些不需要验证的方法
            (cart,)
            b.在web.php/user 配置
        6.前后台登录分离（cookie里面_identity存储用户实例,开启自动登录cookie通过_identity实现登录）

            修改后台登录模型admin里面login(方法)并增加getAdmin(方法)
            在web.php自定义admin
            Admin(模型)继承接口\yii\web\IdentityInterface，并实现五个方法 （修改模型里使用admin组件）
            此时登录或回到登录页面
            a.修改后台common控制器里面方法(注释掉session判断) 完成登录
            此时 ： session里面id和cookie里面_identity会和前台冲突 (继续配置web.php增加idparam)
            此时：退出会把前后台session同时清掉，
            在前台member/logout传false(不清除所有session)
            后台public/logout 传false
        7.后台用户登录判断
            在后台common控制器中增加behaviors方法，然后再各个页面添加属性
        8.Yii2处理密码
            哈希方式（MD5，SHA1）
            ->bcrypt : Yii::$app->getSecurity()->generatePasswordHash($password);
            a. usermodel->reg(方法)  改变加密算法
            b. usermodel->validatePass(方法验证用户密码)
            c. adminmodel->reg(方法)
            d. adminmodel->validatePass(验证管理员密码)
    三.RBAC (Role Based Access Control)
        用户：
        角色：(权限集合)
        权限：(操作)
        登陆后认证用户角色->根据角色查出用户权限列表->用户访问权限判断是否具有这种能力
        数据库形式
        auth_item:存储角色或者权限表
            (name:角色或者权限名称,type:角色或者权限分类(1角色,2权限),rule_name规则名称)
        auth_item_child :角色权限关联表
            (parent:角色，child:权限)
        auth_assignment : 用户角色权限表
            (item_name :角色或者权限,user_id:用户id,)
        auth_rule :规则表
            (name:规则名称 (AuthorRule),data:对象实例化后,序列化的值)
        文件形式：yii\rbac\Phpmanager  (存储到  @app/rbac 目录)

        使用类：
            yii\rbac\Item,角色或者权限基类,用字段type来区分
            Yii]rbac\Role Role代表角色的类
            Yii\rbac|permission 控制权限操作的类
            Yii\rbac|assignment 用户与角色的关联
            Yii\rbac\Rule 判断角色权限的额外规则

        1.在config/web配置'authManager'，
        2.vendor/yiisoft/yii/rbac/migrations/找到mysql数据表
        3.在config/console.php配置'authManager'
        4.进入yii2shop目录, yii migrate --migrationPath=@yii/rbac/migrations，创建四张数据表
        5.在layouts1添加权限管理布局，新建RbacController
            完成角色添加 (表 auth_item)  rbac/Createrole
            $auth = Yii::$app->authManager;
            $role = $auth->createRole
            $auth->add($role)
        6.  显示角色列表  rbac/roles
            1.修改布局文件
            2.'query' => (new Query)->from($auth->itemTable) 查询数据
            3.ActiveDataProvider 将数据传递到模板
            4.加载_items.php 通过grid布局
        7. 权限添加  将所有权限插入到数据表
            yii hello/index
            yii hello/index aqie
            在commands下新建RbacController,执行 yii rbac/init
        8.  给角色分配权限 (可以分配子节点，也可以分配子角色)
            1.$auth = Yii::$app->authManager;    拿到auth对象
            给角色添加权限 或者给角色添加子节点 (表auth_item_child)
            2.  rbac/assign
                RbacController控制器添加分配权限方法 actionAssignitem() 获取所有角色信息和权限信息
            3.新建模型 mofules/models/Rbac.php
            通过getOptions($data, $parent)对数据处理
            点击分配在控制器actionAssignitem（判断）通过模型中addChild(方法)将数据写入
            (表auth_item_child)，parent就是当前角色名称
            4. 控制器rbac/assignitem(方法)定义$children,
                调用模型里面getChildrenByName()实现assignitem页面已经分配权限勾选
        9.给管理员授权
            1.在视图层manage/managers.php添加manage/assign 并在manage控制器新建assign方法加载
            _assign模板
            2.操作表(auth_assignment)给每个管理员分配角色和权限
            3.点击授权提交表单，在manager/actionAssign进行判断
            4.在rbac模型里面编写grant(方法 和addChild(区别？？？？))完成用户授权
            5. 在manager/actionAssign进行判断定义$children,调用模型Rbac里面getChildrenByUser()实现已经分配权限勾选
            模板中将$children传进去

        10.后台管理员登陆后，对所有权限进行验证
            1. modules/controllers/CommonController
                通过brforeAction方法，判断当前管理员是否拥有访问权限
            2.给每个管理员分配角色
             首先新建一个角色，然后给对应管理员分配角色，或者分配权限
        11.核心规则 rule(不允许其他管理员删除本管理员内容) 表(shop_auth_rule)
            规则就是一个类,
            1.可以model/category/add 方法中直接加adminid字段
            2.替代上面方法 model/category/behaviors  分类添加更改时候对adminid字段进行插入或更新
            3.创建类models/AuthorRule.php
            4.在layouts添加链接，然后在rbaccontroller控制器新建actionCreaterule(创建规则方法)
            加载_createrule.php模板
            添加规则 AuthorRule ->添加新角色(规则名称isAuthor) (表shop_auth_item)
            select * from shop_auth_item where type = 1;
            先判断权限,然后判断规则
            5.创建角色   名称：(测试规则), 标识：testrules 规则名称 isAuthor
                然后创建管理员ruler,给管理员分配角色 拥有category所有权限，但是因为规则，他删除不了
            (扩展只能编辑自己的内容)
    四：对后台菜单进行优化
        1.没有权限菜单不显示出来
            a.在config下新建adminmenu.php
            b.在web.php下进行配置 $adminmenu = require(__DIR__. '/adminmenu.php');
            'params' => array_merge($params,['adminmenu'=>$adminmenu]),
            c.重写lauyout1页面
            d.添加默认权限(分配默认权限)
            web.php  'defaultRoles' => ['default'],
            e.角色列表，更新删除(没做)

    五：商品的全文检索(Elasticsearch)(www.elastic.co)
        1.介绍 ： 分布式实时文件存储,每个字段都被索引可被搜索
        分布式实时搜索引擎
        可以扩展到上百台服务器，处理PB级结构化或非结构化数据
        向mysql插入数据也要向es插入数据,标题描述
        安装完成要配置
        a,直接在官网下载压缩包,设置该目录为ES_HOME环境变量   F:\yii2shop\ES\elasticsearch-2.4.1 (之前5.3.0)
        b.path中添加%ES_HOME%\bin;
        c.在任意目录运行 %ES_HOME%\bin\elasticsearch.bat  运行127.0.0.1:9200  (这个是前端运行)
        d.进入%ES_HOME%\bin\目录安装service.bat install
        e.service start

        2.  a.安装Java环境 配置环境变量
        b.F:\yii2shop\elasticsearch-5.3.0\bin>elasticsearch.bat
        c.安装分词插件 github(Elasticsearch-analysis)  地址(https://github.com/medcl/elasticsearch-analysis-ik)
        d.通过git下载到 F:\gits\elasticsearch-analysis-ik
        e.git clone git@github.com:medcl/elasticsearch-analysis-ik.git
        cd elasticsearch-analysis-ik
        git checkout tags/v1.10.1                   (分词版本之前是master)
        f.安装maven 配置环境变量 D:\develop\maven-3.39;
        mvn package
        g.打包完成以后
        target/releases有个压缩包
        解压缩,放到es/plugins/ik
        重启服务 service stop   service start

        h.安装head插件
        plugin install mobz/elasticsearch-head
        启动插件 ; http://localhost:9200/_plugin/head/
        3.
        standard
        1.下载curl，配置环境变量 curl "http://www.yii2.com:9200"
        通过curl命令  curl -XPOST "http://www.yii2.com:9200/_analyze?analyzer=standard&pretty" -d '11dfsgdgdfb啊切' 分词用analyzer
        curl -XPOST "http://www.yii2.com:9200/_analyze?analyzer=standard&pretty" -d "突然兴奋"
        curl -XPOST "http://www.yii2.com:9200/_analyze?analyzer=ik&pretty&pretty" -d '啊切的名字是aqie'
        curl -XGET "http://localhost:9200/_analyze?pretty&analyzer=ik" -d "联想是全球最大的笔记本厂商"
        curl -XPOST  "http://localhost:9200/_analyze?analyzer=standard&pretty=true&text=我是中国人"
        curl "http://localhost:9200/_analyze?analyzer=ik&pretty=true" -d "{"text":"世界这么大"}"

        浏览器运行分词 ：
        http://www.yii2.com:9200/_analyze?analyzer=ik&text=北京欢迎你aa

        2. 创建索引 (aqie_shop)
        curl -XPUT "http://localhost:9200/aqie_shop" -d '@createindex.json'
        curl -XPUT "http://localhost:9200/aqie_shop/products/1?pretty" -d '{""productid"":1,""title"":""这是个文章标题"",""descr"":""这是一个商品描述""}'
        3.查找索引
        搜索所有的  curl -XGET "http://localhost/aqie_shop/_search?pretty
        加限制 ：curl -XPOST "http://localhost/aqie_shop/_search?pretty -d '{}'  // 写一个文件search.json
        4.搜索
        curl -XGET "http://localhost/aqie_shop/_search?pretty"
        curl -POST "http://localhost/aqie_shop/_search?pretty" -d '@search.json'
        5.第三方批量导入工具 (https://github.com/jprante/elasticsearch-jdbc) 版本2.3.4.0
        a.mysql-blog.sh改下配置
        b.复制一份到mysql-import-product.sh
        4. yii2项目中使用es ()
        1.进入yii2shop  php composer.phar require --prefer-dist yiisoft/yii2-elasticsearch
        2.在web.php配置elasticsearch
        3.在layouts里面搜索部分添加form
        4.product/search 新建方法
        5.在model里面新建模型 ;ProductSearch模型
        5.
        a.curl -XGET "http://localhost:9200/aqie_shop/_search?pretty"       // 查看es存储数据
        b.数据库更新自动更新到es (判断更新时间) 数据表(shop_product)更新字段
        c.在product模型 写一个behavior(方法) 完成更新时间和添加时间自动更新
        d.

    六：redis异步发送邮件  (yii2 redis 插件)  flushall(清空redis库) (yii mailer/send)
        1.之前实现：用户点击注册->连接服务器邮箱->注册信息发送给邮箱服务器->邮箱服务器返回结果到本地服务器
        2.用户注册->将注册信息存储在内存队列->通知用户发送成功
        服务端离线监听内存队列-》将队列中邮件数据依次发送
        3.安装redis服务->编写yii2插件类->重写Swiftmailer类方法
        4.php composer.phar require --prefer-dist yiisoft/yii2-redis
        5.配置web.php文件中加redis
        6.在前台控制器IndexController 进行简单测试
        7.之前邮件在web里面配置mailer
        member/reg ->调用user模型里面regByMail() send方法改成queue(将邮件写入到队列)
        mailer类->compose(方法)
        vendor->swiftmailer->

        // mailer 类  http://www.yiiframework.com/doc-2.0/yii-swiftmailer-mailer.html
        note : a.  mailer 通过 实例化 $messageClass ,再调用Message类
        8.创建目录 ： vendor->aqie->mailerqueue->src->Message.php  (对message类扩展)
        a. 新建类Message 继承\yii\swiftmailer\Message
        新建方法queue();  在web.php mailer 配置 db
        //  http://www.yiiframework.com/doc-2.0/yii-swiftmailer-message.html
        b.新建类MailerQueue
        9.配置web.php
        1. 'class'=>'aqie\mailerqueue\MailerQueue',
        2. 'aliases'
        3.改user模型 $mailer->queue();
        4.对message.php进行调试   此时邮件存进redis队列   select 1  -> keys * ->lrange mails 0 100
        5.在commands文件下新建MailerController.php
        在mailer控制器新建Send(方法);   \Yii::$app->mailer->process();
        6.将web.php里面mailer,redis复制到console.php里面,路径也复制过去
        7.进入控制台,yii2shop  调用yii mailer/send
        8.上传到github     https://github.com/aqie123/redisMail
        9.上传到composer   https://packagist.org/

    七 ：redis (redis-cli.exe -h 127.0.0.1 -p 6379) (del key) ()
        1.缓存菜单
        a.配置web.php cache
        b.vendor/yii2soft/yii2-redis/Cache.php  查看配置
        c.web.php 配置cache   并开启debug  配置$config['modules']['debug']
        d.开启缓存前1273ms  6M内存  db 34  -> 缓存后 db->25 db 83ms
        f.前台common控制器把商品分类缓存到2号库   select 2  -> keys * ->get menu
        2.缓存购物车
        a.common控制器，先修改认证体系
        b.修改shop_cart字段,Cart模型里面新建behaviors(方法) 自动更新购物车修改时间
        (当购物车字段更新时候,更新缓存 common控制器里面 $dep)
        c.此时新添加购物车就会自动更新缓存  select 2->keys * -> get menu
        3.对商品做查询缓存 (将查询缓存起来,key类似sql语句)
        a.缓存前38个查询->28个查询->26个查询
        b.common控制器里面查询和index控制器里面查询
        4.session 存储到redis
        a.默认存储到 windows/temp/下
        b.session_set_save_handler
        c.web.php配置session 配置好后 （redis-cli.exe -h 127.0.0.1 -p 6379 ->select 3 -> keys * ）
        5.url 美化(url manager)
        a.http://www.yii2.com/index.php?r=index/index  -> http://www.yii2.com/index/index
        后台首页 http://www.yii2.com/aqieback.html
        b.nginx : location /{ try_files $uri $uri/ /index.php?$args; }
        c.apache : .htaccess
        c.   配置web.php里面  yii\web\UrlManager    urlManager 此时地址都会变
        d.配置web.php 里面 errorHandler  在index控制器里面 添加index/error方法
    加载404页面
    八:日志文件 （yii\log\Logger  Class yii\log\Target）
        a.web.php配置项log
        Yii::trace() Yii::error() Yii::warning() Yii::info() Yii::beginProfile()    Yii::endProfile()
        b.在index控制器使用trace方法,runtime/logs/app.log      'levels' => ['trace','error', 'warning'],
        c.在index控制器使用info方法,runtime/logs/app.log      'levels' => ['info','error', 'warning'],
        d.log中配置 ： 'logFile'=>'@app/runtime/logs/shop/application.log',
        e.第三方日志收集 （https://sentry.io/aqie/yii2shop/getting-started/?signup）  github(hellowearemito/yii2-sentry)
        f.composer下载sentry，并在web.php配置sentry和log 配置dsn和publicdsn
        g.在首页触发warnning会自动发送邮件      --失败
    九：消息队列
        a.场景1：用户注册成功，发送注册邮件,再发送短信。
        串行方式，将注册信息写入数据库成功后，向用户发送邮件，再返回客户端
        并行方式：写入成功后，发送邮件同时发送短信,返回客户端
        消息队列：将注册信息写入数据库，注册信息写入消息队列,发送邮件和短信的消费者异步读取消息队列
        写入消息对列将结果返回客户端
        b.场景2：应用解耦（用户下单后，订单系统通知库存系统）
        传统：订单系统调用库存系统接口
        消息队列：
        订单系统：用户下单，订单系统完成持久化处理,将消息写入消息队列，返回用户订单成功
        库存系统：订阅下单消息,采用推拉方式,获取下单信息,库存系统根据下单信息,进行库存操作
        c.场景三：流量削锋(秒杀活动)
        传统方式：服务端突然接收来自前端大量订单
        消息队列：
        1.用户请求,服务端接收后,首先写入消息对列.消息队列长度超过最大值,抛弃用户请求或跳转到错误页面
        d.场景四：
        1.解决大量日志传输问题,日志采集客户端,采集数据队列,写入Kafka队列
        2.kafka消息队列，负责日志消息接收存储和转发
        3.日志处理应用,订阅并消费kafka队列中日志数据
        f.消息通讯
        1.点对点消息对列,
        A和B使用同一队列,进行消息通讯
        2. 聊天室
        a,b,c,d,订阅同一主题,进行消息发布接收
        g.kafka(kafka.apache.org) 高吞吐量的分布式发布订阅消息系统
        a.优势：
        1.高吞吐量
        2.支持kafka服务器和消费机集群来区分消息
        3.支持hadoop并行数据加载
        b.基本
        1.broker: kafka集群中一台或多台服务器
        2.topic: kafka处理的消息源的不同分类
        3.partition: topic物理上分组,topic可以分为多个partition，
        每个partition都是一个有序队列
        每条消息都会被分配一个有序的id(offset)
        4.Message:消息,通信的基本单位,每个producer可以向一个topic发布消息
        5.Producers:消息和数据生产这,向kafka的一个topic发布消息的过程叫做producers
        6.Consumers:消息和数据消费者,订阅topics并处理其发布消息过程
        c.安装：
        1.下载kafka,
        2.安装zookeeper(http://zookeeper.apache.org/releases.html#download)
        3.http://blog.csdn.net/evankaka/article/details/52421314
        4.http://www.cnblogs.com/alvingofast/p/kafka_deployment_on_windows.html
        http://mirror.bit.edu.cn/apache/zookeeper/
        5.安装zookeeper ,并添加系统变量ZOOKEEPER_HOME,运行  zkserver (2128)
        6.添加换将变量 KAFKA_HOME %KAFKA_HOME%\bin\windows;
        7.打开kafka : (D:\develop\kafka_2.12-0.10.2.0)
        .\bin\windows\kafka-server-start.bat .\config\server.properties
        8.创建topics:  (\bin\windows)   这是打开第三个窗口
        kafka-topics.bat --create --zookeeper localhost:2181 --replication-factor 1 --partitions 1 --topic test
        9.Producer                  第四个窗口
        kafka-console-producer.bat --broker-list localhost:9092 --topic test
        10.Consumer                 第五个窗口
        kafka-console-consumer.bat --zookeeper localhost:2181 --topic test
        11.安装kafka 的php扩展
        a.edenhill/librdkafka
        b.arnaud/php-rdkafka   github

    十：MYSQL主从复制
        a.   1.数据分布
        2.负载均衡 (读写分离)
        3.备份
        4.高可用性和容错性
        b.Master将改变记录到二进制日志
        Slave将Master的binary log events拷贝到他的中继日志(rely log)
        Slave重做中继日志中事件,将改变反应他的数据
        c.查看binlog是否开启 ：    show variables like 'log_%';
        查看data路径 ：  show variables like '%datadir%';
        在mysql.ini : log-bin=D:\phpStudy\MySQL\log\mysql-bin.log
        重启mysql : net start mysql   mysqld --install

        导出数据库备份：mysqldump -u root -p aqie_shop>aqie_shop.sql
        (aqie_shop(yii2),article(原生博客),imooc_singcms(tpCMS),message(原生留言板),product(联系用),shop(原生商城))
        (test2(练习),zns_ajax(vue的留言板))
        导入文件：mysql>source aqie_shop.sql;

        查看binlog :  show binary logs;(可以查看自己binlog的名称)        show master status;
        show binlog events; =>可以查看已生成的binlog
        show master logs;
        d.主机允许从机监听
        grant replication slave on *.* to slave@192.168.1.102 identified by '123456'
    十一：mysql双主热备




















