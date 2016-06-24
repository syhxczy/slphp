<?php
//输出json
function gojson($data)
{
    return json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
}

//发送短信验证码
function sendx($to,$datas,$tempId)
{
     // 初始化REST SDK
     $accountSid= 'aaf98f89529afd5a01529bb2f93201c2';

     //主帐号Token
     $accountToken= 'f2d66d955f544726a22b788a6483368c';
 
     //应用Id
     $appId='8aaf0708554d8271015552a0583408f2';
 
     //请求地址，格式如下，不需要写https://
     $serverIP='sandboxapp.cloopen.com';
 
     //请求端口 
     $serverPort='8883';
 
     //REST版本号
     $softVersion='2013-12-26';
     $rest = new REST($serverIP,$serverPort,$softVersion);
     $rest->setAccount($accountSid,$accountToken);
     $rest->setAppId($appId);
    
     // 发送模板短信
     $result = $rest->sendTemplateSMS($to,$datas,$tempId);
     if($result == NULL ) {
         echo "result error!";
         break;
     }
     if($result->statusCode!=0) {
         echo "error code :" . $result->statusCode . "<br>";
         echo "error msg :" . $result->statusMsg . "<br>";
         //TODO 添加错误处理逻辑
     }else{
         echo "Sendind TemplateSMS success!<br/>";
         // 获取返回信息
         $smsmessage = $result->TemplateSMS;
         echo "dateCreated:".$smsmessage->dateCreated."<br/>";
         echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
         //TODO 添加成功处理逻辑
     }
}

//邮件发送类
function sende($adress,$content)
{
    $mail = new PHPMailer();
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'syh35kd@163.com';                 // SMTP username
    $mail->Password = 'qazwsx';                           // SMTP password

    $mail->From = 'syh35kd@163.com';
    $mail->FromName = 'syh';
    $mail->addAddress($adress);
    // Add a recipient

    $mail->Subject = 'Here is the subject';
    $mail->Body    = $content;

    if(!$mail->send()) {
        echo 'Message could not be sent.';
    } else {
        echo 'Message has been sent';
    }
}

