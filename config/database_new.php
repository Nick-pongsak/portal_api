<?php
define('realPath',  '/app/html/web');
define('Server_Addr',  'https://dev-salesops.dhas.com');

####### Connect Cipher #########
// define('Server_Cipher',  'http://dev-cipher.dhas.com:84/api/v2/');
define('Server_Cipher',  'http://10.7.200.166/api/v2/');
define('API_Cipher_PORT',  '80');
define('Cipher_DB',  'SimpliCore');
define('DreamFactory_Session_Token',  'c0be2ead2bfab53636c32a1cfa1ee8b5826479d63c57b99cc3f0cbfda0788473');
define('API_Cipher',  'http://10.7.200.166:82/');
// define('API_Sync','http://10.7.200.178:82/');

define('Mail_Server',  'mail.dhas.com');
define('Mail_Port',  '10325');
define('API_CipherV2',  'http://10.7.200.166:85/');
################################

return [
    'default' => 'salesops',
    'connections' => [
        'salesops' => [
            'driver'    => 'mysql',
	        'host'      => '10.7.200.179',
            'port'      => '3306',
            'database'  => 'salesops',
            'username'  => 'iconnect',
            'password'  => 'Ic0nnecT',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => '',
            'strict'    => false,
			'options'   => array(
                PDO::MYSQL_ATTR_LOCAL_INFILE => true,
			    PDO::ATTR_EMULATE_PREPARES => true
            ),
        ],
        'edi' => array(
            'driver'    => 'mysql',
            'host'      => '10.7.200.179',
            'port'      => '3306',
            'database'  => 'EDI',
            'username'  => 'iconnect',
            'password'  => 'Ic0nnecT',

            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => '',
            'strict'    => false,
			'options'   => array(
                PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            ),
        ),
        'mongodb' => array(
            'driver' => 'mongodb',
              'host' => '10.7.200.178',
              'port' => 27017,
              'database' => 'salesops',
              'username' => '',
              'password' => '',
              'options' => [
                'database'=>'salesops'
                ]
        ),
        'mongodbCipher' => array(
            'driver' => 'mongodb',
            'host' => '10.7.200.240',
            'port' => 27017,
            'database' => 'simplicore',
            'username' => '',
            'password' => '',
            'options' => [
                'database'=>'simplicore'
            ]
        ),
        'mongodbMKT' => array(
            'driver' => 'mongodb',
            'host' => '10.7.200.135',
            'port' => 27001,
            'database' => 'mktOpsDB',
            'username' => '',
            'password' => '',
            'options' => [
                'database'=>'mktOpsDB'
            ]
        ),
        'Bill' => array(
            'driver'    => 'mysql',
            'host'      => '10.7.200.133',
            'port'      => '3306',
            'database'  => 'bill_collection',
            'username'  => 'iconnect',
            'password'  => 'Ic0nnecT',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => '',
            'strict'    => false,
            'options'   => array(
                PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            ),
        ),
//        'sqlsrv' => [
//            'driver' => 'sqlsrv',
//            'host' => '10.5.174.52',
//            'database' => 'BNF',
//            'username' => 'sa',
//            'password' => 'P@ssw0rd',
//            'charset' => 'utf8',
//        ],
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', base_path('database/database.sqlite')),
            'prefix' => env('DB_PREFIX', ''),
        ]
    ],
    'fetch' => PDO::FETCH_CLASS,
    'redis' => [
                'client' => 'predis',
                'default' => [
                   // 'host' => 'localhost',
                    'host' => '10.7.200.178',
                    'password' => null,
                    'port' => 6379,
                    'database' => 0,
                ],
            ],
];
