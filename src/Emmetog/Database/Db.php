<?php

namespace Emmetog\Database;

class Db
{

    /**
     * An array of external connection objects in use.
     *
     * @var array
     */
    private static $connections;

    public static function getConnection($host, $database, $username, $password, $port = null, $socket = null)
    {
        $key = md5($host . $database . $username . $password . $port . $socket);

        if (!isset(self::$connections[$key]))
        {
            self::$connections[$key] = new \PDO(
                            'mysql:host=' . $host . ';dbname=' . $database,
                            $username, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
            );
//            self::$connections[$key]->connect(
//                    $host, $database, $username, $password
//            );
        }

        return self::$connections[$key];
    }

}

?>
