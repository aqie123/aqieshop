<p>尊敬的<strong><?php echo $adminuser; ?> </strong> ，您好:</p>

<p>您的找回密码链接如下</p>

<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['admin/manage/mailchangepass','timestamp'=>$time,'adminuser'=>$adminuser,'token'=>$token])?>
<p><a href="<?php echo $url; ?>"><?php echo $url; ?></a></p>

<p>请在五分钟之内点击此链接,请勿传递给别人</p>

<p>该邮件为系统自动发送，请勿回复！</p>

<p>摸摸达^_^</p>