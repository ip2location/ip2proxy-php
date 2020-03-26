# IP2Proxy PHP Module
[![Latest Stable Version](https://img.shields.io/packagist/v/ip2location/ip2proxy-php.svg)](https://packagist.org/packages/ip2location/ip2proxy-php)
[![Total Downloads](https://img.shields.io/packagist/dt/ip2location/ip2proxy-php.svg?style=flat-square)](https://packagist.org/packages/ip2location/ip2proxy-php)

This module allows user to query an IP address if it was being used as open proxy, web proxy, VPN anonymizer and TOR exits. It lookup the proxy IP address from **IP2Proxy BIN Data** file. This data file can be downloaded at

* Free IP2Proxy BIN Data: https://lite.ip2location.com
* Commercial IP2Proxy BIN Data: https://www.ip2location.com/proxy-database

## Methods
Below are the methods supported in this class.



### BIN Database Class

|Method Name|Description|
|---|---|
|open|Open the IP2Proxy BIN data for lookup. Please see the **Usage** section of the 3 modes supported to load the BIN data file.|
|close|Close and clean up the file pointer.|
|getPackageVersion|Get the package version (1 to 4 for PX1 to PX4 respectively).|
|getModuleVersion|Get the module version.|
|getDatabaseVersion|Get the database version.|
|isProxy|Check whether if an IP address was a proxy. Returned value:<ul><li>-1 : errors</li><li>0 : not a proxy</li><li>1 : a proxy</li><li>2 : a data center IP address</li></ul>|
|getAll|Return the proxy information in array.|
|getProxyType|Return the proxy type. Please visit <a href="https://www.ip2location.com/databases/px4-ip-proxytype-country-region-city-isp" target="_blank">IP2Location</a> for the list of proxy types supported|
|getCountryShort|Return the ISO3166-1 country code (2-digits) of the proxy.|
|getCountryLong|Return the ISO3166-1 country name of the proxy.|
|getRegion|Return the ISO3166-2 region name of the proxy. Please visit <a href="https://www.ip2location.com/free/iso3166-2" target="_blank">ISO3166-2 Subdivision Code</a> for the information of ISO3166-2 supported|
|getCity|Return the city name of the proxy.|
|getISP|Return the ISP name of the proxy.|
|getDomain|Internet domain name associated with IP address range.|
|getUsageType|Usage type classification of ISP or company. Refer to usage type reference below.|
|getASN|Autonomous system number (ASN).|
|getAS|Autonomous system (AS) name.|
|getLastSeen|Proxy last seen in days.|



### Web Service Class

| Method Name | Description                                                  |
| ----------- | ------------------------------------------------------------ |
| Constructor | Expect 3 input parameters:<ol><li>IP2Proxy API Key.</li><li>Package (PX1 - PX8)</li><li>Use HTTPS or HTTP</li></ol> |
| lookup      | Return the proxy information in array.<ul><li>countryCode</li><li>countryName</li><li>regionName</li><li>cityName</li><li>isp</li><li>domain</li><li>usageType</li><li>asn</li><li>as</li><li>lastSeen</li><li>proxyType</li><li>isProxy</li></ul>                       |
| getCredit   | Return remaining credit of the web service account.          |



## Usage

### BIN Database

Open and read IP2Proxy binary database. There are 3 modes:

1. **\IP2Proxy\Database::FILE_IO** - File I/O reading. Slower look, but low resource consuming.
2. **\IP2Proxy\Database::MEMORY_CACHE** - Caches database into memory for faster lookup. Required high memory.
3. **\IP2Proxy\Database::SHARED_MEMORY** - Stores whole IP2Proxy database into system memory. Lookup is possible across all applications within the system.  Extremely resources consuming. Do not use this mode if your system do not have enough memory.

```php
require 'class.IP2Proxy.php';

$db = new \IP2Proxy\Database();
$db->open('./samples/IP2PROXY-IP-PROXYTYPE-COUNTRY-REGION-CITY-ISP-DOMAIN-USAGETYPE-ASN-LASTSEEN.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);
```

To start lookup result from database, use the following codes:

```
$records = $db->getAll('1.0.241.135');
```

Results are returned in array.

```php
echo '<p><strong>IP Address: </strong>' . $records['ipAddress'] . '</p>';
echo '<p><strong>IP Number: </strong>' . $records['ipNumber'] . '</p>';
echo '<p><strong>IP Version: </strong>' . $records['ipVersion'] . '</p>';
echo '<p><strong>Country Code: </strong>' . $records['countryCode'] . '</p>';
echo '<p><strong>Country: </strong>' . $records['countryName'] . '</p>';
echo '<p><strong>State: </strong>' . $records['regionName'] . '</p>';
echo '<p><strong>City: </strong>' . $records['cityName'] . '</p>';

/*
  Type of proxy: VPN, TOR, DCH, PUB, WEB
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
```

Note: if you are getting error such as `Call to undefined function IP2Proxy\gmp_import()`, you probably did not have the module to install or enable in php.ini. You can check your php.ini to make sure that the module has been enabled.

### Web Service API

To lookup by Web service, you will need to sign up for [IP2Proxy Web Service](https://www.ip2location.com/web-service/ip2proxy) to get a API key.

Start your lookup by following codes:

```php
require 'class.IP2Proxy.php';

// Lookup by Web API
$ws = new \IP2Proxy\WebService('YOUR_API_KEY',  'PX8', false);

$results = $ws->lookup('1.0.241.135');

if ($results !== false) {
    echo '<p><strong>Country Code: </strong>' . $results['countryCode'] . '</p>';
    echo '<p><strong>Country Name: </strong>' . $results['countryName'] . '</p>';
    echo '<p><strong>Region: </strong>' . $results['regionName'] . '</p>';
    echo '<p><strong>City: </strong>' . $results['cityName'] . '</p>';
    echo '<p><strong>ISP: </strong>' . $results['isp'] . '</p>';
    echo '<p><strong>Domain: </strong>' . $results['domain'] . '</p>';
    echo '<p><strong>Usage Type: </strong>' . $results['usageType'] . '</p>';
    echo '<p><strong>ASN: </strong>' . $results['asn'] . '</p>';
    echo '<p><strong>AS: </strong>' . $results['as'] . '</p>';
    echo '<p><strong>Last Seen: </strong>' . $results['lastSeen'] . ' Day(s)</p>';
    echo '<p><strong>Proxy Type: </strong>' . $results['proxyType'] . '</p>';
    echo '<p><strong>Is Proxy: </strong>' . $results['isProxy'] . '</p>';
}
```



# Reference

### Usage Type

- (COM) Commercial
- (ORG) Organization
- (GOV) Government
- (MIL) Military
- (EDU) University/College/School
- (LIB) Library
- (CDN) Content Delivery Network
- (ISP) Fixed Line ISP
- (MOB) Mobile ISP
- (DCH) Data Center/Web Hosting/Transit
- (SES) Search Engine Spider
- (RSV) Reserved