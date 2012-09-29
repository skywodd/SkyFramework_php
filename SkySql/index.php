<?php
define('APPS_RUNNING', true);

include_once 'SkySql.class.php';

try {
    echo '<p>Instanciate new SkySql</p>';
    $sql = new SkySql('localhost', 'skyduino', 'skyduino', 'skyduino');
    
    if($sql->getConnectError())
        die('Got problem !');
    
    $query = $sql->query('SHOW TABLES');
    
    while($row = $query->fetch_row())
        print_r($row);
    
    $query->close();
    
    echo '<br /><br />';
    
    $sql2 = SkySql::getInstance();
    
    $query = $sql2->query('SHOW TABLES');
    
    while($row = $query->fetch_row())
        print_r($row);
    
    $query->close();
    
    echo '<br /><br />';
    
    echo 'Sql count ' . $sql->getQueryCount() . '<br />';
    echo 'Sql time ' . $sql->getExecutionTime() . '<br />';
    
    $sql->close();
    
} catch (Exception $e) {
    echo '<p>Got exception : ' . $e->getMessage() . '</p>';
}
?>