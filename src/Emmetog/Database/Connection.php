<?php

namespace Emmetog\Database;

use Emmetog\Database\ConnectionInterface;
use Emmetog\Config\Config;

abstract class Connection implements ConnectionInterface
{

    const TYPE_INTEGER = 101;
    const TYPE_STRING = 102;
    const TYPE_DATE = 103;
    const TYPE_BOOLEAN = 104;
    const TYPE_IDENTIFIER = 105;
    const TYPE_RAW = 106;

    /**
     * @var Config
     */
    protected $config;

    final public function __construct(Config $config)
    {
        $this->config = $config;
    }

}

class ConnectionException extends \Exception
{
    
}

class ConnectionInvalidValueTypeException extends ConnectionException
{
    
}

class ConnectionInvalidParamNameException extends ConnectionException
{
    
}

class ConnectionInvalidQueryException extends ConnectionException
{
    
}

class ConnectionQueryNotPreparedException extends ConnectionException
{
    
}

?>
