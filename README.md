### IP2Proxy PHP Module

This is the PHP module to lookup IP2Proxy databases from https://www.ip2location.com/proxy-database

**IP2Proxy Database** contains IP addresses which are used as VPN anonymizer, open proxies, web proxies and Tor exits. The database includes records for all public IPv4 addresses.



#### Usage

Open and read IP2Proxy binary database. There are 3 modes:

1. **\IP2Proxy\Database::FILE_IO** - File I/O reading. Slower look, but low resource consuming.
2. **\IP2Proxy\Database::MEMORY_CACHE** - Caches database into memory for faster lookup. Required high memory.
3. **\IP2Proxy\Database::SHARED_MEMORY** - Stores whole IP2Proxy database into system memory. Lookup is possible across all applications within the system.  Extremely resources consuming. Do not use this mode if your system do not have enough memory.

```
require 'class.IP2Proxy.php';

$db = new \IP2Proxy\Database('./samples/IP2PROXY-IP-PROXYTYPE-COUNTRY-REGION-CITY-ISP.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);
```

To start lookup result from database, use the following codes:

```
$records = $db->getAll('1.0.241.135');
```

Results are returned in array.

```
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
```



