<?php
return array(
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'from' => array(
        'address' => 'tung.ly.com@gmail.com',
        'name' => 'Tung Ly App'
    ),
    'encryption' => 'tls',
    'username' => 'tung.ly.com',
    'password' => 'tunglycom',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false
)
;
