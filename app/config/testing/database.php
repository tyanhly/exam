<?php
return array(
    'fetch' => PDO::FETCH_CLASS,
    'default' => 'mysql',
    'connections' => array(
        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'exam_testing',
            'username'  => 'root',
            'password'  => 'x',
        ),
    ),
);
