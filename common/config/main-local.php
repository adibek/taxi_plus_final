<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=rossoner_taxi',
            'username' => 'root',
            'password' => 'password',
            'charset' => 'utf8',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@backend/views/mail/',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => 'partner@priceclick.kz',
                'password' => '112233',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
    ],
];
