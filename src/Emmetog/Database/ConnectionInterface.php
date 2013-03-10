<?php

namespace Apl\Database;

interface ConnectionInterface {
    
     public function connect($profile);
     
     public function setOptions($options);
     
     public function prepare($query, $description);
     
     public function bindParam($param, $value, $type);
     
     public function execute();
    
}
?>
