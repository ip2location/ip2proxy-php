# Quickstart

## Dependencies

This library requires IP2Location BIN database to function. You may download the BIN database at

-   IP2Location LITE BIN Data (Free): <https://lite.ip2location.com>
-   IP2Location Commercial BIN Data (Comprehensive):
    <https://www.ip2location.com>

:::{note}
An outdated BIN database was provided in the data folder for your testing. You are recommended to visit the above links to download the latest BIN database.
:::

## Installation

Install this package using the command as below:

```
composer require ip2location/ip2proxy-php
```

## Sample Codes

### Query geolocation information from BIN database

You can query the geolocation information from the IP2Location BIN database as below:

```php
require 'vendor/autoload.php';

$db = new \IP2Proxy\Database('vendor/ip2location/ip2proxy-php/data/PX11.SAMPLE.BIN', \IP2PROXY\Database::FILE_IO);

$records = $db->lookup('1.0.0.8', \IP2PROXY\Database::ALL);

echo '<p><strong>IP Address: </strong>' . $records['ipAddress'] . '</p>';
echo '<p><strong>IP Number: </strong>' . $records['ipNumber'] . '</p>';
echo '<p><strong>IP Version: </strong>' . $records['ipVersion'] . '</p>';
echo '<p><strong>Country Code: </strong>' . $records['countryCode'] . '</p>';
echo '<p><strong>Country: </strong>' . $records['countryName'] . '</p>';
echo '<p><strong>State: </strong>' . $records['regionName'] . '</p>';
echo '<p><strong>City: </strong>' . $records['cityName'] . '</p>';

/*
  Type of proxy: VPN, TOR, DCH, PUB, WEB, RES (RES available in PX11 only)
*/
echo '<p><strong>Proxy Type: </strong>' . $records['proxyType'] . '</p>';

/*
  Returns -1 on errors
  Returns 0 is not proxy
  Return 1 if proxy
  Return 2 if it's data center IP
*/
echo '<p><strong>Is Proxy: </strong>' . $records['isProxy'] . '</p>';
echo '<p><strong>ISP: </strong>' . $records['isp'] . '</p>';
echo '<p><strong>Domain: </strong>' . $records['domain'] . '</p>';
echo '<p><strong>Usage Type: </strong>' . $records['usageType'] . '</p>';
echo '<p><strong>ASN: </strong>' . $records['asn'] . '</p>';
echo '<p><strong>AS: </strong>' . $records['as'] . '</p>';
echo '<p><strong>Last Seen: </strong>' . $records['lastSeen'] . '</p>';
echo '<p><strong>Threat: </strong>' . $records['threat'] . '</p>';
echo '<p><strong>Provider: </strong>' . $records['provider'] . '</p>';
```