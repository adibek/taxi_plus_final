<?php
    namespace backend\components;
    use Yii;

    class SendMail {
        public static function SendRegistration($email, $password, $role) {
            Yii::$app->mail->getView()->params['email'] = $email;
            Yii::$app->mail->getView()->params['password'] = $password;
            Yii::$app->mail->getView()->params['role'] = $role;
            Yii::$app->mail->compose('html')
                ->setFrom('info@priceclick.kz')
                ->setTo($email)
                ->setSubject('Вы были зарегистрированы на проекте FBS admin!' )
                ->send();
        }
        public static function SendFeedbackinf($name, $phone) {
            Yii::$app->mail->getView()->params['name'] = $name;
            Yii::$app->mail->getView()->params['phone'] = $phone;
            Yii::$app->mail->compose()
                ->setFrom('info@priceclick.kz')
                ->setTo('zhandosspecial@gmail.com')
                ->setSubject('Вам отправили заявку на обратную связь!' )
                ->setTextBody('Текст сообщения')
                ->setHtmlBody('<b>
                                   <tr>
                                       <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #333333; text-align:left;line-height: 24px;"> 
                                           <div style = "margin-top:10px;">
                                               <strong>Данные клиента:</strong><br/>
                                               Имя: '.$name.' <br/>
                                               Номер:'. $phone.'
                                           </div>
                                       </td>
                                   </tr>
                               </b>')
                ->send();
        }
        public static function SendFeedbacktext($name, $phone,$text) {
            Yii::$app->mail->getView()->params['name'] = $name;
            Yii::$app->mail->getView()->params['phone'] = $phone;
            Yii::$app->mail->getView()->params['text'] = $text;
            Yii::$app->mail->compose()
                ->setFrom('info@priceclick.kz')
                ->setTo('zhandosspecial@gmail.com')
                ->setSubject('Вам отправили заявку на обратную связь!' )
                ->setTextBody(' <strong>Данные клиента:</strong><br/>')
                ->setHtmlBody('<b>
                                   <tr>
                                       <td style="font-family: Helvetica, arial, sans-serif; font-size: 13px; color: #333333; text-align:left;line-height: 24px;"> 
                                           <div style = "margin-top:10px;">
                                               <strong>Данные клиента:</strong><br/>
                                               Имя: '.$name.' <br/>
                                               Номер:'. $phone.'<br/>
                                               Текст: <b>'.$text.'</b>
                                           </div>
                                       </td>
                                   </tr>
                               </b>')
                ->send();
        }
    }
?>
