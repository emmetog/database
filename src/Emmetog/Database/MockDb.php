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

    const INPUT_FORMAT_ARRAY   = 500;
    const INPUT_FORMAT_CONSOLE = 501;

    /**
     * Creates a new MockDb object, this is used to mock database tables.
     * 
     * @param \Emmetog\Config\ConfigForMocking $config The ConfigForMocking object.
     * @param \Emmetog\Config\Config $real_config A real config object, used to get
     *              the structure of the real table (optional). If not specified then
     *              the same config dir and cache as the ConfigForMocking object are
     *              used to create a new (real) config object.
     */
    public function __construct(ConfigForMocking $config, Config $real_config = null)
    {
        $this->config = $config;

        if (!$real_config)
        {
            $real_config = new Config($config->getConfigDirectory(), $config->getCache());
        }

        $this->mockDbModelReal = new MockDbModel($real_config);
        $this->mockDbModelTest = new MockDbModel($this->config);
    }

    /**
     * Mocks a table.
     * 
     * @param string $table_name The name of the table to mock.
     * @param mixed $data The data to insert into the mocked table.
     * @param integer $input_format The format of the mocked data, must be one of MockDb::INPUT_FORMAT_ARRAY, MockDb::INPUT_FORMAT_CONSOLE.
     * @param string $profile The profile of the table to mock, defaults to the "default" profile.
     * @throws MockDbInvalidInputFormatException If an unknown input format is specified.
     */
    public function mockTable($table_name, $data, $input_format = self::INPUT_FORMAT_ARRAY, $profile = 'default')
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
        $create_table_query = $this->mockDbModelReal->getCreateTableQuery($table_name, $profile);

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
