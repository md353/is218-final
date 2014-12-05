<?php

require 'autoloader.php';

spl_autoload_register('autoloader::autoload');

require('connectionPDO.php');

$sth = $dbh->prepare('SELECT * FROM departments');

$sth->execute();

$results = $sth->fetchAll();

print_r($results);

?>