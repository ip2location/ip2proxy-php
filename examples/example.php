<?php

error_reporting(\E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';

// Lookup by local BIN database
$db = new \IP2Proxy\Database('./data/PX12.SAMPLE.BIN', \IP2PROXY\Database::FILE_IO);

echo 'Module Version: ' . $db->getModuleVersion() . \PHP_EOL . \PHP_EOL;
echo 'Package: PX' . $db->getPackageVersion() . \PHP_EOL;
echo 'Database Date: ' . $db->getDatabaseVersion() . \PHP_EOL;
echo '$records = $db->lookup(\'23.90.12.224\', \IP2PROXY\Database::ALL);' . \PHP_EOL;
$records = $db->lookup('23.83.130.186', \IP2PROXY\Database::ALL);
print_r($records);

echo \PHP_EOL . \PHP_EOL;

echo 'Web Service' . \PHP_EOL;

// Lookup by Web API
$ws = new \IP2Proxy\WebService('demo', 'PX11', false);

$results = $ws->lookup('1.0.0.8');
print_r($results);
