<?php
function getLastInsertId(){
    $_db;

    global $db_config;
    $dsn = $db_config['driver'] . ':';
    foreach ($db_config['dsn'] as $key => $value) {
        $dsn .= $key . '=' . $value . ';';
    }

    try {
        $_db = new PDO($dsn, $db_config['username'], $db_config['password']);
        $_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*if (($db_config['driver'] == 'pgsql') && isset($db_config['schema'])) {
            $_db->query(sprintf("SET SEARCH_PATH TO %s", $db_config['schema']));
        }*/
    } catch (PDOException $e) {
        error_log($e->getMessage());
    }
    
    return $_db->lastInsertId();
}
?>