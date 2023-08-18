# IP2Location PHP API

## Database Class
```{py:class} Database(database_file_path, file_mode)
Load the IP2Location BIN database.

:param str database_file_path: (Required) The file path links to IP2Location BIN databases.
:param str file_mode: (Optional) Caching mode (one of FILE_IO, MEMORY_CACHE, or SHARED_MEMORY).
```

```{py:function} getPackageVersion()
Return the database's type, 1 to 10 respectively for PX1 to PX11. Please visit https://www.ip2location.com/databases/ip2proxy for details.

:return: Returns the package version.
:rtype: string
```

```{py:function} getModuleVersion()
Return the version of module.

:return: Returns the module version.
:rtype: string
```

```{py:function} getDatabaseVersion()
Return the database's compilation date as a string of the form 'YYYY-MM-DD'.

:return: Returns the database version.
:rtype: string
```

```{py:function} lookup(ip_address)
Retrieve geolocation information for an IP address.

:param str ip_address: (Required) The IP address (IPv4 or IPv6).
:return: Returns the geolocation information in array. Refer below table for the fields avaliable in the array
:rtype: array

**RETURN FIELDS**

| Field Name       | Description                                                  |
| ---------------- | ------------------------------------------------------------ |
| countryCode    |     Two-character country code based on ISO 3166. |
| countryName    |     Country name based on ISO 3166. |
| regionName     |     Region or state name. |
| cityName       |     City name. |
| isp            |     Internet Service Provider or company\'s name. |
| domain         |     Internet domain name associated with IP address range. |
| usageType      |     Usage type classification of ISP or company. |
| asn            |     Autonomous system number (ASN). |
| as             |     Autonomous system (AS) name. |
| lastSeen       |     Proxy last seen in days. |
| threat         |     Security threat reported. |
| proxyType      |     Type of proxy. |
| provider       |     Name of VPN provider if available. |
```