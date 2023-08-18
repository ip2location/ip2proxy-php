# IP2Proxy PHP Module
[![Latest Stable Version](https://img.shields.io/packagist/v/ip2location/ip2proxy-php.svg)](https://packagist.org/packages/ip2location/ip2proxy-php)
[![Total Downloads](https://img.shields.io/packagist/dt/ip2location/ip2proxy-php.svg?style=flat-square)](https://packagist.org/packages/ip2location/ip2proxy-php)

This module allows user to query an IP address if it was being used as open proxy, web proxy, VPN anonymizer and TOR exits. It lookup the proxy IP address from **IP2Proxy BIN Data** file. This data file can be downloaded at

* Free IP2Proxy BIN Data: https://lite.ip2location.com
* Commercial IP2Proxy BIN Data: https://www.ip2location.com/proxy-database

## Developer Documentation
To learn more about installation, usage, and code examples, please visit the developer documentation at [https://ip2proxy-php.readthedocs.io/en/latest/index.html.](https://ip2proxy-php.readthedocs.io/en/latest/index.html)

# Reference

### Proxy Type

| Type | Description                                                  | Anonymity |
| ---- | ------------------------------------------------------------ | --------- |
| VPN  | Anonymizing VPN services. These services offer users a publicly accessible VPN for the purpose of hiding their IP address. | High      |
| TOR  | Tor Exit Nodes. The Tor Project is an open network used by those who wish to maintain anonymity. | High      |
| DCH  | Hosting Provider, Data Center or Content Delivery  Network. Since hosting providers and data centers can serve to provide  anonymity, the Anonymous IP database flags IP addresses associated with  them. | Low       |
| PUB  | Public Proxies. These are services which make connection requests on a user's behalf. Proxy server software can be configured by the administrator to listen on some specified port. These differ from  VPNs in that the proxies usually have limited functions compare to VPNs. | High      |
| WEB  | Web Proxies. These are web services which make web  requests on a user's behalf. These differ from VPNs or Public Proxies in that they are simple web-based proxies rather than operating at the IP  address and other ports level. | High      |
| SES  | Search Engine Robots. These are services which perform  crawling or scraping to a website, such as, the search engine spider or  bots engine. | Low       |
| RES  | Residential proxies. These services offer users proxy  connections through residential ISP with or without consents of peers to share their idle resources. Only available with PX11 | Medium    |



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