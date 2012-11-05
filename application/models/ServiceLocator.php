<?php
class Application_Model_ServiceLocator
{
    private static $service = [];

    private static function setDb($index, $options)
    {
        if(!isset(static::$service[$index]))
        {
            $db = Zend_Db::factory('PDO_MYSQL', $options);

            $db->setFetchMode(PDO::FETCH_OBJ);

            static::$service[$index] = $db;
        }
        return static::$service[$index];
    }

    public static function getDb($db_name, $database = null)
    {
        switch($db_name)
        {
            case 'db10':
                $options = ['host'=>'192.168.202.1',
                            'username'=>'123',
                            'password'=>'123',
                            'dbname'=>$database,
                static::setDb('db10', $options);
                break;
            case 'db':
            default:
                $options = ['host'=>'192.168.202.25',
                            'username'=> '123',
                            'password'=>'123',
                            'dbname'=>'bam',
                            'profiler' => true];
                static::setDb('db', $options);

                Zend_Db_Table_Abstract::setDefaultAdapter(static::$service['db']);
                break;
        }

        return static::$service[$db_name];
    }

    public static function getMailTransport($service)
    {
        switch($service)
        {
            case 4775:
                $mailConfig = array(
                    'host' => "smtp.socketlabs.com",
                    'port' => "25",
                    'authentication' => "login",
                    'username' => "123",
                    'password' => "123"
                );

                $transport = new Zend_Mail_Transport_Smtp(
                    $mailConfig['host'],
                    array(
                         'port' => $mailConfig['port'],
                         'auth' => $mailConfig['authentication'],
                         'username' => $mailConfig['username'],
                         'password' => $mailConfig['password']
                    )
                );
                Zend_Mail::setDefaultTransport($transport);
                break;
            case 5154:
            default:
                $mailConfig = ['host' => "smtp.socketlabs.com",
                               'port' => "25",
                               'authentication' => "login",
                               'username' => "123",
                               'password' => "123"];

                $transport = new Zend_Mail_Transport_Smtp(
                    $mailConfig['host'],
                    ['port' => $mailConfig['port'],
                    'auth' => $mailConfig['authentication'],
                    'username' => $mailConfig['username'],
                    'password' => $mailConfig['password']]
                );
                Zend_Mail::setDefaultTransport($transport);
                break;
        }
        return $transport;
    }

    public static function getSmsTransport($service)
    {
        switch($service)
        {
            case 'sms':
                $config = array(
                    'username'    => '123',
                    'password'    => '123',
                    'environment' => Zend_Service_DeveloperGarden_SendSms::ENV_PRODUCTION,
                );
                break;
        }

        return $config;

    }
}