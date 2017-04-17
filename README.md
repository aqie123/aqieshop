##啊切商城(终板)

- 前台功能
    * 前台商品展示,二级菜单展示(无限分类)
    * 商品分类展示和详情页展示
    * 加入购物车->结算->支付(没接口)
        ->订单展示->确认收货->展示物流
    * qq登录(本机域名解析用http://www.sxlzrc.com访问)
    * 邮箱注册(邮件放入redis队列)
    * ES全文搜索 (未实现)
- 后台功能
    * 管理员列表分页展示，添加，删除，授权，
       修改密码，修改邮箱，邮箱找回密码
    * 用户列表分页展示，添加，删除
    * 权限管理：创建角色,角色列表,分配权限,创建规则
    * 商品分类展示jstree,添加，(指定权限的)修改，删除
    * 商品列表分页展示，添加，编辑，删除，上下架
    * 订单列表，发货
    * 相册列表，添加图片
-   优化
    * 伪静态
    * 查询缓存
    * sentry日志收集
    * 用户认证体系
    * Assets资源组件
    
- web 目录作为网站根目录
- 数据库备份在ER目录
- 项目具体介绍在about.php 
    * 首页：www.aqie.com (假设网站名是这个) 
    * http://www.sxlzrc.com(本地解析这个域名可以登陆qq)
    * 后台首页： www.aqie.com/aqieback   
    * 图片存在七牛图床,需要联网加载
- master 全部代码 删除冗余注释
- dev    全部代码yii2完整版
- basic  前期代码基本功能完整


