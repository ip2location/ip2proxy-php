<?php

declare(strict_types=1);

namespace IP2Proxy\Test\DatabaseTest;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
	public function testInvalidDatabase()
	{
		try {
			$db = new \IP2Proxy\Database('./data/NULL.BIN', \IP2Proxy\Database::FILE_IO);
		} catch (\Exception $e) {
			$this->assertStringContainsString('does not seem to exist.', $e->getMessage());
		}
	}

	public function testInvalidIp()
	{
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$records = $db->lookup('1.0.0.x', \IP2Proxy\Database::ALL);

		$this->assertStringContainsString('INVALID IP ADDRESS', $records['countryCode']);
	}

	public function testIpv4CountryCode()
	{
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$records = $db->lookup('1.0.0.8', \IP2Proxy\Database::ALL);

		$this->assertEquals('US', $records['countryCode']);
	}

	public function testIpv4CountryName()
	{
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$records = $db->lookup('1.0.0.8', \IP2Proxy\Database::ALL);

		$this->assertEquals(
			'United States of America',
			$records['countryName'],
		);
	}

	public function testLookupCountryCode() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('US', $db->lookup('1.0.0.8', \IP2Proxy\Database::COUNTRY_CODE));
	}

	public function testLookupCountryName() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('United States of America', $db->lookup('1.0.0.8', \IP2Proxy\Database::COUNTRY_NAME));
	}

	public function testLookupRegionName() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('California', $db->lookup('1.0.0.8', \IP2Proxy\Database::REGION_NAME));
	}

	public function testLookupCityName() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('Los Angeles', $db->lookup('1.0.0.8', \IP2Proxy\Database::CITY_NAME));
	}

	public function testLookupIsp() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('APNIC and CloudFlare DNS Resolver Project', $db->lookup('1.0.0.8', \IP2Proxy\Database::ISP));
	}

	public function testLookupIsProxy() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals(2, (string) $db->lookup('1.0.0.8', \IP2Proxy\Database::IS_PROXY));
	}

	public function testLookupProxyType() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('DCH', $db->lookup('1.0.0.8', \IP2Proxy\Database::PROXY_TYPE));
	}

	public function testLookupDomain() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('cloudflare.com', $db->lookup('1.0.0.8', \IP2Proxy\Database::DOMAIN));
	}

	public function testLookupUsageType() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('CDN', $db->lookup('1.0.0.8', \IP2Proxy\Database::USAGE_TYPE));
	}

	public function testLookupAsn() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('13335', $db->lookup('1.0.0.8', \IP2Proxy\Database::ASN));
	}

	public function testLookupAs() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('CLOUDFLARENET', $db->lookup('1.0.0.8', \IP2Proxy\Database::_AS));
	}

	public function testLookupLastSeen() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('22', $db->lookup('1.0.0.8', \IP2Proxy\Database::LAST_SEEN));
	}

	public function testLookupThreat() {
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertEquals('-', $db->lookup('1.0.0.8', \IP2Proxy\Database::THREAT));
	}

	public function testIpv6CountryCode()
	{
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$records = $db->lookup('2c0f:ffa0::4', \IP2Proxy\Database::ALL);

		$this->assertEquals('UG', $records['countryCode']);
	}

	public function testIpv6CountryName()
	{
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$records = $db->lookup('2c0f:ffa0::4', \IP2Proxy\Database::ALL);

		$this->assertEquals('Uganda', $records['countryName']);
	}

	public function testPackageVersion()
	{
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertMatchesRegularExpression('/^[0-9]+$/', (string) $db->getPackageVersion());
	}

	public function testModuleVersion()
	{
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertMatchesRegularExpression('/^[0-9]+\.[0-9]+\.[0-9]+$/', (string) $db->getModuleVersion());
	}

	public function testDatabaseVersion()
	{
		$db = new \IP2Proxy\Database('./data/PX10.SAMPLE.BIN', \IP2Proxy\Database::FILE_IO);

		$this->assertMatchesRegularExpression('/^[0-9]+\.[0-9]+\.[0-9]+$/', (string) $db->getDatabaseVersion());
	}
}
