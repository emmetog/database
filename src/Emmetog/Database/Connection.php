<?php

namespace Apl\Database;

abstract class Connection implements \Apl\Database\ConnectionInterface
{

    const TYPE_INTEGER = 101;
    const TYPE_STRING = 102;
    const TYPE_DATE = 103;
    const TYPE_BOOLEAN = 104;
    const TYPE_IDENTIFIER = 105;
    const TYPE_RAW = 106;

    /**
     * @var \Apl\Config\Config
     */
    protected $config;

    final public function __construct(\Apl\Config\Config $config)
    {
        $this->config = $config;
    }

}

class ConnectionException extends \Exception
{
    
}

class ConnectionInvalidValueTypeException extends \Apl\Database\ConnectionException
{
    
}

class ConnectionInvalidParamNameException extends \Apl\Database\ConnectionException
{
    
}

class ConnectionInvalidQueryException extends \Apl\Database\ConnectionException
{
    
}

class ConnectionQueryNotPreparedException extends \Apl\Database\ConnectionException
{
    
}

?>
