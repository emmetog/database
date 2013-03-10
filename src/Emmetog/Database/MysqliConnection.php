<?php

namespace Apl\Database;

class MysqliConnection extends \Apl\Database\Connection
{

    private $connection;
    private $boundValues = array();
    private $query = '';

    public function connect($host, $database, $username, $password, $port = null, $socket = null) {
	$this->connection = mysqli_connect($host, $username, $password, $database, $port, $socket);
    }

    public function setOptions($options) {
	
    }

    public function execute() {

	$boundParams = $this->getBoundParams();

	foreach ($boundParams as $param => $value) {
	    $this->query = str_replace($param, $value, $this->query);
	}

	$statement = mysqli_prepare($this->connection, $this->query);
	
	$result = mysqli_stmt_execute($statement);

	$return = mysqli_stmt_fetch($statement);
	$return = mysqli_stmt_($statement);
	
	var_dump($return); die;
	
	return $return;
    }

    public function prepare($query) {
	$this->query = $query;
    }

    public function bindValue($param, $value, $type) {
	if (':' != substr($param, 0, 1)) {
	    throw new \Apl\Database\ConnectionInvalidParamNameException('Param must start with the \':\' character');
	}

	switch ($type) {
	    case \Apl\Database\Connection::TYPE_INTEGER:
		$this->boundValues[$param] = $value;
		break;
	    case \Apl\Database\Connection::TYPE_STRING:
		$this->boundValues[$param] = '"' . $value . '"';
		break;
	    case \Apl\Database\Connection::TYPE_DATE:
		$this->boundValues[$param] = '"' . $value . '"';
		break;
	    case \Apl\Database\Connection::TYPE_BOOLEAN:
		$this->boundValues[$param] = (string) (boolean) $value;
		break;
	    default:
		throw new \Apl\Database\ConnectionInvalidValueTypeException('Value type must be one of the TYPE_* constants');
		break;
	}
    }

    public function getBoundParams() {
	return $this->boundValues;
    }

}

?>
