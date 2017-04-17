如果忘记密码 Admin/login(在验证那里加叹号) $this->load($data) && !$this->validate()

1.用户登录后不显示登录页面   新增
2.管理员邮箱修改           （之前使用session获取用户名）  (checked)
3.管理员邮箱修改密码manage/mailchangepass        总是跳转到登录页面(继承commoncontroller)
    (rbac影响到用户认证体系)(checked)
 (登录也继承common控制器,但是在权限管理里面开放default的login权限,然后再用户认证体系把login放进$except)
 (如果那个方法所在控制器不继承common，rbac就白写了，继承了就这个方法不能用，当时恶心死了)
4.后台首页完善            新增
5.商品属性完善            新增
6.原始访问路径不生效     （http://www.yii2.com/index.php?r=admin/public/login）
7. $model->changepass($post)  (model)
8.params里面路径  （改为绝对路径）
9.用户注册页面 $model->userpass = ''; (去除注册时左边登录显示的密码)  (checked)
10.前台登录密码错误，会报错（不和谐） (checked)
11.qq登陆后不显示用户名 修改了qq登录  (checked)
12.会员编辑功能    新增
13.会员注册验证码  新增
14.商品添加
15.商品修改  (封面会报错)(验证针对add) (checked)
16.前台和后台登录如果用户名不存在,会报错   if else (checked) Admin.php 54行  User.php 50行  (checked)
