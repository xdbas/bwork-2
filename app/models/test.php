<?php

class TestModel extends \Bwork\Data\PDO {
    
    public function test() {
        $stmt = $this->db()->prepare('SHOW TABLES');
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
    
}