<?php

namespace Emmetog\Database;

use Emmetog\Model\MockDbModel;
use Emmetog\Config\Config;
use Emmetog\Config\ConfigForMocking;

class MockDb
{

    /**
     * @var Config 
     */
    private $config;
    
    /**
     * @var MockDbModel 
     */
    private $mockDbModelReal;
    
    /**
     * @var MockDbModel 
     */
    private $mockDbModelTest;

    const INPUT_FORMAT_ARRAY = 500;
    const INPUT_FORMAT_CONSOLE = 501;

    public function __construct(ConfigForMocking $config, Config $real_config=null)
    {
        $this->config = $config;
        
        if(!$real_config) {
            $real_config = new Config();
        }

        $this->mockDbModelReal = $config->getClass(MockDbModel);
        $this->mockDbModelTest = new MockDbModel($this->config);
    }

    public function mockTable($table_name, $data,
            $input_format = self::INPUT_FORMAT_CONSOLE)
    {
        switch ($input_format)
        {
            case self::INPUT_FORMAT_CONSOLE:
                $data = $this->parseInputFormatConsole($data);
                break;
            case self::INPUT_FORMAT_ARRAY:
                break;
            default:
                throw new MockDbInvalidInputFormatException('Unknown input format');
        }

        /**
         * Get the structure from the 'real' database
         * @todo throw an exception if the table does not exist.
         */
        $create_table_query = $this->mockDbModelReal->getCreateTableQuery($table_name);
        
        $result = $this->mockDbModelTest->createTable($create_table_query);
        
        $result = $this->mockDbModelTest->insertDataIntoMockedTable($table_name, $data['fields'], $data['data']);
        
        
        
    }

    private function parseInputFormatConsole($data)
    {
        throw new MockDbInvalidInputFormatException('The INPUT_FORMAT_CONSOLE format is not yet implemented');
    }

}

class MockDbException extends \Exception
{
    
}

class MockDbInvalidInputFormatException extends MockDbException
{
    
}

?>
