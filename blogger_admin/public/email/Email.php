<?php
namespace app\index\model;
use think\Db;
use think\Loader;
use PHPMailer;
class Emailclass
{
    //发送邮件
    public function SendEmail($to,$title,$content){
        include "../public/phpmailer/class.phpmailer.php";
        include "../public/phpmailer/class.smtp.php";
        $mail = new PHPMailer();        //实例化
        $mail->IsSMTP();        //设置要发送邮件
        $mail->IsHTML(TRUE);        //是否允许要发送html代码
        $mail->CharSet = 'UTF-8';       //设置文字格式
        $mail->SMTPAuth = TRUE;     //是否需要身份验证
        $mail->From = "";  //邮箱
        $mail->FromName = "";     //标题
        $mail->Host = "smtp.163.com";       //发送邮件的服务协议地址
        $mail->Username = "";       //用户名 邮箱
        $mail->Password = "";      //密码123 令牌密码
        $mail->Port = 25;       //发邮件端口号默认25
        $mail->AddAddress($to);     //收件人
        $mail->Subject = $title;    //标题
        $mail->Body = $content;     //内容
        return ($mail->send());
    }
}