<?php
require 'class.IP2Proxy.php';

// Lookup by local BIN database
$db = new \IP2Proxy\Database();
$db->open('./data/IP2PROXY-IP-PROXYTYPE-COUNTRY-REGION-CITY-ISP-DOMAIN-USAGETYPE-ASN-LASTSEEN-THREAT-RESIDENTIAL.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

$countryCode = $db->getCountryShort('1.0.241.135');
echo '<p><strong>Country Code: </strong>' . $countryCode . '</p>';

$countryName = $db->getCountryLong('1.0.241.135');
echo '<p><strong>Country: </strong>' . $countryName . '</p>';

$regionName = $db->getRegion('1.0.241.135');
echo '<p><strong>Region: </strong>' . $regionName . '</p>';

$cityName = $db->getCity('1.0.241.135');
echo '<p><strong>City: </strong>' . $cityName . '</p>';

$isp = $db->getISP('1.0.241.135');
echo '<p><strong>ISP: </strong>' . $isp . '</p>';

$proxyType = $db->getProxyType('1.0.241.135');
echo '<p><strong>Proxy Type: </strong>' . $proxyType . '</p>';

$isProxy = $db->isProxy('1.0.241.135');
echo '<p><strong>Is Proxy: </strong>' . $isProxy . '</p>';

$domain = $db->getDomain('1.0.241.135');
echo '<p><strong>Domain: </strong>' . $domain . '</p>';

$usageType = $db->getUsageType('1.0.241.135');
echo '<p><strong>Usage Type: </strong>' . $usageType . '</p>';

$asn = $db->getASN('1.0.241.135');
echo '<p><strong>ASN: </strong>' . $asn . '</p>';

$as = $db->getAS('1.0.241.135');
echo '<p><strong>AS: </strong>' . $as . '</p>';

$lastSeen = $db->getLastSeen('1.0.241.135');
echo '<p><strong>Last Seen: </strong>' . $lastSeen . '</p>';

$threat = $db->getThreat('1.0.241.135');
echo '<p><strong>Threat: </strong>' . $threat . '</p>';

$records = $db->getAll('1.0.241.135');

echo '<pre>';
print_r($records);
echo '</pre>';

$db->close();

// Lookup by Web API
$ws = new \IP2Proxy\WebService('demo',  'PX10', false);

$results = $ws->lookup('1.0.241.135');

echo '<pre>';
print_r($results);
echo '</pre>';
