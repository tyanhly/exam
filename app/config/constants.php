<?php

return array(
    'perPage' => '10',
    'perPageList' => array(
        '10' => '10',
        '20' => '20',
        '50' => '50',
        '100' => '100',
        '200' => '200'
    ),
    'listPageValidator' => array(
        'page' => 'numeric|min:1',
        'perPage' => 'numeric|min:10',
        'orderBy' => 'regex:/^[a-zA-Z_]+$/',
        'orderValue' => 'in:DESC,ASC',
        'keywords' => ''
    ),
);
