<?php

/*
 * Copyright (C) 2005-2019 IP2Location.com
 * All Rights Reserved
 *
 * This library is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace IP2Proxy;

/**
 * IP2Proxy database class.
 */
class Database
{
	/**
	 * Current module's version.
	 *
	 * @var string
	 */
	const VERSION = '2.0.0';

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Error field constants  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Unsupported field message.
	 *
	 * @var string
	 */
	const FIELD_NOT_SUPPORTED = 'NOT SUPPORTED';

	/**
	 * Unknown field message.
	 *
	 * @var string
	 */
	const FIELD_NOT_KNOWN = 'This parameter does not exists. Please verify.';

	/**
	 * Invalid IP address message.
	 *
	 * @var string
	 */
	const INVALID_IP_ADDRESS = 'INVALID IP ADDRESS';

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Field selection constants  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Country code (ISO 3166-1 Alpha 2).
	 *
	 * @var int
	 */
	const COUNTRY_CODE = 1;

	/**
	 * Country name.
	 *
	 * @var int
	 */
	const COUNTRY_NAME = 2;

	/**
	 * Region name.
	 *
	 * @var int
	 */
	const REGION_NAME = 3;

	/**
	 * City name.
	 *
	 * @var int
	 */
	const CITY_NAME = 4;

	/**
	 * ISP name.
	 *
	 * @var int
	 */
	const ISP = 5;

	/**
	 * Is proxy.
	 *
	 * @var int
	 */
	const IS_PROXY = 6;

	/**
	 * Proxy type.
	 *
	 * @var int
	 */
	const PROXY_TYPE = 7;

	/**
	 * Domain.
	 *
	 * @var int
	 */
	const DOMAIN = 8;

	/**
	 * Usage type.
	 *
	 * @var int
	 */
	const USAGE_TYPE = 9;

	/**
	 * ASN.
	 *
	 * @var int
	 */
	const ASN = 10;

	/**
	 * AS.
	 *
	 * @var int
	 */
	const _AS = 11;

	/**
	 * Last seen.
	 *
	 * @var int
	 */
	const LAST_SEEN = 12;

	/**
	 * Country name and code.
	 *
	 * @var int
	 */
	const COUNTRY = 101;

	/**
	 * All fields at once.
	 *
	 * @var int
	 */
	const ALL = 1001;

	/**
	 * Include the IP address of the looked up IP address.
	 *
	 * @var int
	 */
	const IP_ADDRESS = 1002;

	/**
	 * Include the IP version of the looked up IP address.
	 *
	 * @var int
	 */
	const IP_VERSION = 1003;

	/**
	 * Include the IP number of the looked up IP address.
	 *
	 * @var int
	 */
	const IP_NUMBER = 1004;

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Exception code constants  ////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Generic exception code.
	 *
	 * @var int
	 */
	const EXCEPTION = 10000;

	/**
	 * No shmop extension found.
	 *
	 * @var int
	 */
	const EXCEPTION_NO_SHMOP = 10001;

	/**
	 * Failed to open shmop memory segment for reading.
	 *
	 * @var int
	 */
	const EXCEPTION_SHMOP_READING_FAILED = 10002;

	/**
	 * Failed to open shmop memory segment for writing.
	 *
	 * @var int
	 */
	const EXCEPTION_SHMOP_WRITING_FAILED = 10003;

	/**
	 * Failed to create shmop memory segment.
	 *
	 * @var int
	 */
	const EXCEPTION_SHMOP_CREATE_FAILED = 10004;

	/**
	 * The specified database file was not found.
	 *
	 * @var int
	 */
	const EXCEPTION_DBFILE_NOT_FOUND = 10005;

	/**
	 * Not enough memory to load database file.
	 *
	 * @var int
	 */
	const EXCEPTION_NO_MEMORY = 10006;

	/**
	 * No candidate databse files found.
	 *
	 * @var int
	 */
	const EXCEPTION_NO_CANDIDATES = 10007;

	/**
	 * Failed to open database file.
	 *
	 * @var int
	 */
	const EXCEPTION_FILE_OPEN_FAILED = 10008;

	/**
	 * Failed to determine the current path.
	 *
	 * @var int
	 */
	const EXCEPTION_NO_PATH = 10009;

	/**
	 * BCMath extension not installed.
	 *
	 * @var int
	 */
	const EXCEPTION_BCMATH_NOT_INSTALLED = 10010;

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Caching method constants  ////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Directly read from the databse file.
	 *
	 * @var int
	 */
	const FILE_IO = 100001;

	/**
	 * Read the whole database into a variable for caching.
	 *
	 * @var int
	 */
	const MEMORY_CACHE = 100002;

	/**
	 * Use shared memory objects for caching.
	 *
	 * @var int
	 */
	const SHARED_MEMORY = 100003;

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Shared memory constants  /////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Share memory segment's permissions (for creation).
	 *
	 * @var int
	 */
	const SHM_PERMS = 0600;

	/**
	 * Number of bytes to read/write at a time in order to load the shared memory cache (512k).
	 *
	 * @var int
	 */
	const SHM_CHUNK_SIZE = 524288;

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Static data  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Column offset mapping.
	 *
	 * Each entry contains an array mapping databse version (0-3) to offset within a record.
	 * A value of 0 means the column is not present in the given database version.
	 *
	 * @static
	 *
	 * @var array
	 */
	private static $columns = [
		self::COUNTRY_CODE => [8,  12,  12,  12,  12,  12,  12,  12,  12],
		self::COUNTRY_NAME => [8,  12,  12,  12,  12,  12,  12,  12,  12],
		self::REGION_NAME  => [0,   0,  16,  16,  16,  16,  16,  16,  16],
		self::CITY_NAME    => [0,   0,  20,  20,  20,  20,  20,  20,  20],
		self::ISP          => [0,   0,   0,  24,  24,  24,  24,  24,  24],
		self::PROXY_TYPE   => [0,   8,   8,   8,   8,   8,   8,   8,   8],
		self::DOMAIN       => [0,   0,   0,   0,  28,  28,  28,  28,  28],
		self::USAGE_TYPE   => [0,   0,   0,   0,   0,  32,  32,  32,  32],
		self::ASN          => [0,   0,   0,   0,   0,   0,  36,  36,  36],
		self::_AS          => [0,   0,   0,   0,   0,   0,  40,  40,  40],
		self::LAST_SEEN    => [0,   0,   0,   0,   0,   0,   0,  44,  44],
  ];

	/**
	 * Column name mapping.
	 *
	 * @static
	 *
	 * @var array
	 */
	private static $names = [
		self::COUNTRY_CODE => 'countryCode',
		self::COUNTRY_NAME => 'countryName',
		self::REGION_NAME  => 'regionName',
		self::CITY_NAME    => 'cityName',
		self::ISP          => 'isp',
		self::IS_PROXY     => 'isProxy',
		self::PROXY_TYPE   => 'proxyType',
		self::DOMAIN       => 'domain',
		self::USAGE_TYPE   => 'usageType',
		self::ASN          => 'asn',
		self::_AS          => 'as',
		self::LAST_SEEN    => 'lastSeen',
		self::IP_ADDRESS   => 'ipAddress',
		self::IP_VERSION   => 'ipVersion',
		self::IP_NUMBER    => 'ipNumber',
  ];

	/**
	 * Database names, in order of preference for file lookup.
	 *
	 * @var array
	 */
	private static $databases = [
		// IPv4 databases
		'IP2PROXY-IP-PROXYTYPE-COUNTRY-REGION-CITY-ISP-DOMAIN-USAGETYPE-ASN-LASTSEEN',
		'IP2PROXY-IP-PROXYTYPE-COUNTRY-REGION-CITY-ISP-DOMAIN-USAGETYPE-ASN',
		'IP2PROXY-IP-PROXYTYPE-COUNTRY-REGION-CITY-ISP-DOMAIN-USAGETYPE',
		'IP2PROXY-IP-PROXYTYPE-COUNTRY-REGION-CITY-ISP-DOMAIN',
		'IP2PROXY-IP-PROXYTYPE-COUNTRY-REGION-CITY-ISP',
		'IP2PROXY-IP-PROXYTYPE-COUNTRY-REGION-CITY',
		'IP2PROXY-IP-PROXYTYPE-COUNTRY',
		'IP2PROXY-IP-COUNTRY',

		// IPv6 databases
		'IPV6-PROXYTYPE-COUNTRY-REGION-CITY-ISP-DOMAIN-USAGETYPE-ASN-LASTSEEN',
		'IPV6-PROXYTYPE-COUNTRY-REGION-CITY-ISP-DOMAIN-USAGETYPE-ASN',
		'IPV6-PROXYTYPE-COUNTRY-REGION-CITY-ISP-DOMAIN-USAGETYPE',
		'IPV6-PROXYTYPE-COUNTRY-REGION-CITY-ISP-DOMAIN',
		'IPV6-PROXYTYPE-COUNTRY-REGION-CITY-ISP',
		'IPV6-PROXYTYPE-COUNTRY-REGION-CITY',
		'IPV6-PROXYTYPE-COUNTRY',
		'IPV6-COUNTRY',
  ];

	/**
	 * Static memory buffer to use for MEMORY_CACHE mode, the keys will be BIN filenames and the values their contents.
	 *
	 * @static
	 *
	 * @var array
	 */
	private static $buffer = [];

	/**
	 * The machine's float size.
	 *
	 * @static
	 *
	 * @var int
	 */
	private static $floatSize = null;

	/**
	 * The configured memory limit.
	 *
	 * @static
	 *
	 * @var int
	 */
	private static $memoryLimit = null;

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Caching backend controls  ////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Caching mode to use (one of FILE_IO, MEMORY_CACHE, or SHARED_MEMORY).
	 *
	 * @var int
	 */
	private $mode;

	/**
	 * File pointer to use for FILE_IO mode, BIN filename for MEMORY_CACHE mode, or shared memory id to use for SHARED_MEMORY mode.
	 *
	 * @var false|int|resource
	 */
	private $resource = false;

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Database metadata  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Database's compilation date.
	 *
	 * @var int
	 */
	private $date;

	/**
	 * Database's type (0-3).
	 *
	 * @var int
	 */
	private $type;

	/**
	 * Database's register width (as an array mapping 4 to IPv4 width, and 6 to IPv6 width).
	 *
	 * @var array
	 */
	private $columnWidth = [];

	/**
	 * Database's pointer offset (as an array mapping 4 to IPv4 offset, and 6 to IPv6 offset).
	 *
	 * @var array
	 */
	private $offset = [];

	/**
	 * Amount of IP address ranges the database contains (as an array mapping 4 to IPv4 count, and 6 to IPv6 count).
	 *
	 * @var array
	 */
	private $ipCount = [];

	/**
	 * Offset withing the database where IP data begins (as an array mapping 4 to IPv4 base, and 6 to IPv6 base).
	 *
	 * @var array
	 */
	private $ipBase = [];

	//hjlim
	private $indexBaseAddr = [];
	private $year;
	private $month;
	private $day;

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Default fields  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Default fields to return during lookup.
	 *
	 * @var array|int
	 */
	private $defaultFields = self::ALL;

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Administrative public interface  /////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * Destructor.
	 */
	public function __destruct()
	{
	}

	/**
	 * @param string $file          Filename of the BIN database to load
	 * @param int    $mode          Caching mode (one of FILE_IO, MEMORY_CACHE, or SHARED_MEMORY)
	 * @param mixed  $defaultFields
	 *
	 * @throws \Exception
	 */
	public function open($file = null, $mode = self::FILE_IO, $defaultFields = self::ALL)
	{
		if (!function_exists('bcadd')) {
			throw new \Exception(__CLASS__ . ': BCMath extension is not installed.', self::EXCEPTION_BCMATH_NOT_INSTALLED);
		}

		// find the referred file and its size
		$rfile = self::findFile($file);
		$size = filesize($rfile);

		// initialize caching backend
		switch ($mode) {
		case self::SHARED_MEMORY:
		// verify the shmop extension is loaded
		if (!extension_loaded('shmop')) {
			throw new \Exception(__CLASS__ . ": Please make sure your PHP setup has the 'shmop' extension enabled.", self::EXCEPTION_NO_SHMOP);
		}

		$limit = self::getMemoryLimit();
		if ($limit !== false && $size > $limit) {
			throw new \Exception(__CLASS__ . ": Insufficient memory to load file '{$rfile}'.", self::EXCEPTION_NO_MEMORY);
		}

		$this->mode = self::SHARED_MEMORY;
		$shmKey = self::getShmKey($rfile);

		// try to open the shared memory segment
		$this->resource = @shmop_open($shmKey, 'a', 0, 0);
		if ($this->resource === false) {
			// the segment did not exist, create it and load the database into it
			$fp = fopen($rfile, 'rb');
			if ($fp === false) {
				throw new \Exception(__CLASS__ . ": Unable to open file '{$rfile}'.", self::EXCEPTION_FILE_OPEN_FAILED);
			}

			// try to open the memory segment for exclusive access
			$shmId = @shmop_open($shmKey, 'n', self::SHM_PERMS, $size);
			if ($shmId === false) {
				throw new \Exception(__CLASS__ . ": Unable to create shared memory block '{$shmKey}'.", self::EXCEPTION_SHMOP_CREATE_FAILED);
			}

			// load SHM_CHUNK_SIZE bytes at a time
			$pointer = 0;
			while ($pointer < $size) {
				$buf = fread($fp, self::SHM_CHUNK_SIZE);
				shmop_write($shmId, $buf, $pointer);
				$pointer += self::SHM_CHUNK_SIZE;
			}
			shmop_close($shmId);
			fclose($fp);

			// now open the memory segment for readonly access
			$this->resource = @shmop_open($shmKey, 'a', 0, 0);
			if ($this->resource === false) {
				throw new \Exception(__CLASS__ . ": Unable to access shared memory block '{$shmKey}' for reading.", self::EXCEPTION_SHMOP_READING_FAILED);
			}
		}
		break;

		case self::FILE_IO:
		$this->mode = self::FILE_IO;
		$this->resource = @fopen($rfile, 'rb');
		if ($this->resource === false) {
			throw new \Exception(__CLASS__ . ": Unable to open file '{$rfile}'.", self::EXCEPTION_FILE_OPEN_FAILED);
		}
		break;

		case self::MEMORY_CACHE:
		$this->mode = self::MEMORY_CACHE;
		$this->resource = $rfile;
		if (!array_key_exists($rfile, self::$buffer)) {
			$limit = self::getMemoryLimit();
			if ($limit !== false && $size > $limit) {
				throw new \Exception(__CLASS__ . ": Insufficient memory to load file '{$rfile}'.", self::EXCEPTION_NO_MEMORY);
			}

			self::$buffer[$rfile] = @file_get_contents($rfile);
			if (self::$buffer[$rfile] === false) {
				throw new \Exception(__CLASS__ . ": Unable to open file '{$rfile}'.", self::EXCEPTION_FILE_OPEN_FAILED);
			}
		}
		break;

		default:
	}

		// determine the platform's float size
		//
		// NB: this should be a constant instead, and some unpack / typebanging magic
		//     should be used to accomodate different float sizes, but, as the libreary
		//     is written, this is the sanest thing to do anyway
		//
		if (self::$floatSize === null) {
			self::$floatSize = strlen(pack('f', M_PI));
		}

		// set default fields to retrieve
		$this->defaultFields = $defaultFields;

		// extract database metadata
		$this->type = $this->readByte(1) - 1;
		$this->columnWidth[4] = $this->readByte(2) * 4;
		$this->columnWidth[6] = $this->columnWidth[4] + 12;
		$this->offset[4] = -4;
		$this->offset[6] = 8;
		$this->year = 2000 + $this->readByte(3);
		$this->month = $this->readByte(4);
		$this->day = $this->readByte(5);
		$this->date = date('Y-m-d', strtotime("{$this->year}-{$this->month}-{$this->day}"));
		$this->ipCount[4] = $this->readWord(6);
		$this->ipBase[4] = $this->readWord(10);
		$this->ipCount[6] = $this->readWord(14);
		$this->ipBase[6] = $this->readWord(18);
		$this->indexBaseAddr[4] = $this->readWord(22);
		$this->indexBaseAddr[6] = $this->readWord(26);
	}

	/**
	 * Close.
	 */
	public function close()
	{
		switch ($this->mode) {
		case self::FILE_IO:
		// free the file pointer
		if ($this->resource !== false) {
			fclose($this->resource);
			$this->resource = false;
		}
		break;
		case self::SHARED_MEMORY:
		// detach from the memory segment
		if ($this->resource !== false) {
			shmop_close($this->resource);
			$this->resource = false;
		}
		break;
	}
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Public interface  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Get the database's package (1-4).
	 *
	 * @return int
	 */
	public function getPackageVersion()
	{
		return $this->type + 1;
	}

	/**
	 * Return the version of module.
	 */
	public function getModuleVersion()
	{
		return self::VERSION;
	}

	/**
	 * Return the version of module.
	 */
	public function getDatabaseVersion()
	{
		return $this->year . '.' . $this->month . '.' . $this->day;
	}

	/**
	 *  Return -1, 0, 1, 2.
	 *
	 * @param mixed $ip
	 */
	public function isProxy($ip)
	{
		return self::lookup($ip, self::IS_PROXY);
	}

	// Return string
	public function getCountryShort($ip)
	{
		return self::lookup($ip, self::COUNTRY_CODE);
	}

	// Return string
	public function getCountryLong($ip)
	{
		return self::lookup($ip, self::COUNTRY_NAME);
	}

	// Return string
	public function getRegion($ip)
	{
		return self::lookup($ip, self::REGION_NAME);
	}

	// Return string
	public function getCity($ip)
	{
		return self::lookup($ip, self::CITY_NAME);
	}

	// Return string
	public function getISP($ip)
	{
		return self::lookup($ip, self::ISP);
	}

	// Return string
	public function getProxyType($ip)
	{
		return self::lookup($ip, self::PROXY_TYPE);
	}

	// Return string
	public function getDomain($ip)
	{
		return self::lookup($ip, self::DOMAIN);
	}

	// Return string
	public function getUsageType($ip)
	{
		return self::lookup($ip, self::USAGE_TYPE);
	}

	// Return string
	public function getASN($ip)
	{
		return self::lookup($ip, self::ASN);
	}

	// Return string
	public function getAS($ip)
	{
		return self::lookup($ip, self::_AS);
	}

	// Return string
	public function getLastSeen($ip)
	{
		return self::lookup($ip, self::LAST_SEEN);
	}

	// Return array
	public function getAll($ip)
	{
		return self::lookup($ip, self::ALL);
	}

	/**
	 * Tear down a shared memory segment created for the given file.
	 *
	 * @param string $file Filename of the BIN database whise segment must be deleted
	 *
	 * @throws \Exception
	 */
	protected function shmTeardown($file)
	{
		// verify the shmop extension is loaded
		if (!extension_loaded('shmop')) {
			throw new \Exception(__CLASS__ . ": Please make sure your PHP setup has the 'shmop' extension enabled.", self::EXCEPTION_NO_SHMOP);
		}

		// Get actual file path
		$rfile = realpath($file);

		// If the file cannot be found, except away
		if ($rfile === false) {
			throw new \Exception(__CLASS__ . ": Database file '{$file}' does not seem to exist.", self::EXCEPTION_DBFILE_NOT_FOUND);
		}

		$shmKey = self::getShmKey($rfile);

		// Try to open the memory segment for writing
		$shmId = @shmop_open($shmKey, 'w', 0, 0);
		if ($shmId === false) {
			throw new \Exception(__CLASS__ . ": Unable to access shared memory block '{$shmKey}' for writing.", self::EXCEPTION_SHMOP_WRITING_FAILED);
		}

		// Delete and close the descriptor
		shmop_delete($shmId);
		shmop_close($shmId);
	}

	/**
	 * Return this database's available fields.
	 *
	 * @param bool $asNames Whether to return the mapped names intead of numbered constants
	 *
	 * @return array
	 */
	protected function getFields($asNames = false)
	{
		$result = array_keys(array_filter(self::$columns, function ($field) {
			return $field[$this->type] !== 0;
		}));

		if ($asNames) {
			$return = [];
			foreach ($result as $field) {
				$return[] = self::$names[$field];
			}

			return $return;
		}

		return $result;
	}

	/**
	 * This function will look the given IP address up in the database and return the result(s) asked for.
	 *
	 * If a single, SINGULAR, field is specified, only its mapped value is returned.
	 * If many fields are given (as an array) or a MULTIPLE field is specified, an
	 * array whith the returned singular field names as keys and their corresponding
	 * values is returned.
	 *
	 * @param string    $ip      IP address to look up
	 * @param array|int $fields  Field(s) to return
	 * @param bool      $asNamed Whether to return an associative array instead
	 *
	 * @return array|bool|mixed
	 */
	protected function lookup($ip, $fields = null, $asNamed = true)
	{
		// extract IP version and number
		list($ipVersion, $ipNumber) = self::ipVersionAndNumber($ip);
		// perform the binary search proper (if the IP address was invalid, binSearch will return false)
		$pointer = $this->binSearch($ipVersion, $ipNumber);

		// apply defaults if needed
		if ($fields === null) {
			$fields = $this->defaultFields;
		}

		// turn fields into an array in case it wasn't already
		$ifields = (array) $fields;
		// add fields if needed
		if (in_array(self::ALL, $ifields)) {
			$ifields[] = self::REGION_NAME;
			$ifields[] = self::CITY_NAME;
			$ifields[] = self::ISP;
			$ifields[] = self::IS_PROXY;
			$ifields[] = self::PROXY_TYPE;
			$ifields[] = self::DOMAIN;
			$ifields[] = self::USAGE_TYPE;
			$ifields[] = self::ASN;
			$ifields[] = self::_AS;
			$ifields[] = self::LAST_SEEN;
			$ifields[] = self::COUNTRY;
			$ifields[] = self::IP_ADDRESS;
			$ifields[] = self::IP_VERSION;
			$ifields[] = self::IP_NUMBER;
		}
		// turn into a uniquely-valued array the fast way
		// (see: http://php.net/manual/en/function.array-unique.php#77743)
		$afields = array_keys(array_flip($ifields));
		// sorting them in reverse order warrants that by the time we get to
		// SINGULAR fields, its MULTIPLE counterparts, if at all present, have
		// already been retrieved
		rsort($afields);

		// maintain a list of already retrieved fields to avoid doing it twice
		$done = [
		self::COUNTRY_CODE => false,
		self::COUNTRY_NAME => false,
		self::REGION_NAME  => false,
		self::CITY_NAME    => false,
		self::ISP          => false,
		self::IS_PROXY     => false,
		self::PROXY_TYPE   => false,
		self::DOMAIN       => false,
		self::USAGE_TYPE   => false,
		self::ASN          => false,
		self::_AS          => false,
		self::LAST_SEEN    => false,
		self::COUNTRY      => false,
		self::IP_ADDRESS   => false,
		self::IP_VERSION   => false,
		self::IP_NUMBER    => false,
	];
		// results are empty to begin with
		$results = [];

		// treat each field in turn
		foreach ($afields as $afield) {
			switch ($afield) {
		// purposefully ignore self::ALL, we already dealt with it
		case self::ALL: break;

		case self::COUNTRY:
			if (!$done[self::COUNTRY]) {
				list($results[self::COUNTRY_NAME], $results[self::COUNTRY_CODE]) = $this->readCountryNameAndCode($pointer);
				$done[self::COUNTRY] = true;
				$done[self::COUNTRY_CODE] = true;
				$done[self::COUNTRY_NAME] = true;
			}
			break;
		case self::COUNTRY_CODE:
			if (!$done[self::COUNTRY_CODE]) {
				$results[self::COUNTRY_CODE] = $this->readCountryNameAndCode($pointer)[1];
				$done[self::COUNTRY_CODE] = true;
			}
			break;
		case self::COUNTRY_NAME:
			if (!$done[self::COUNTRY_CODE]) {
				$results[self::COUNTRY_CODE] = $this->readCountryNameAndCode($pointer)[0];
				$done[self::COUNTRY_CODE] = true;
			}
			break;
		case self::REGION_NAME:
			if (!$done[self::REGION_NAME]) {
				$results[self::REGION_NAME] = $this->readRegionName($pointer);
				$done[self::REGION_NAME] = true;
			}
			break;
		case self::CITY_NAME:
			if (!$done[self::CITY_NAME]) {
				$results[self::CITY_NAME] = $this->readCityName($pointer);
				$done[self::CITY_NAME] = true;
			}
			break;
		case self::ISP:
			if (!$done[self::ISP]) {
				$results[self::ISP] = $this->readIsp($pointer);
				$done[self::ISP] = true;
			}
			break;
		case self::PROXY_TYPE:
			if (!$done[self::PROXY_TYPE]) {
				$results[self::PROXY_TYPE] = $this->readProxyType($pointer);
				$done[self::PROXY_TYPE] = true;
			}
			break;
		case self::IS_PROXY:
			if (!$done[self::IS_PROXY]) {
				// px1
				if ($this->type == 0) {
					$countryCode = $this->readCountryNameAndCode($pointer)[1];

					$results[self::IS_PROXY] = ($countryCode == '-') ? 0 : 1;

					if (strlen($countryCode) > 2) {
						$results[self::IS_PROXY] = -1;
					}
				} else {
					$proxyType = $this->readProxyType($pointer);

					$results[self::IS_PROXY] = ($proxyType == '-') ? 0 : (($proxyType == 'DCH') ? 2 : 1);

					if (strlen($proxyType) > 3) {
						$results[self::IS_PROXY] = -1;
					}
				}

				$done[self::IS_PROXY] = true;
			}
			break;

		case self::DOMAIN:
			if (!$done[self::DOMAIN]) {
				$results[self::DOMAIN] = $this->readDomain($pointer);
				$done[self::DOMAIN] = true;
			}
			break;

		case self::USAGE_TYPE:
			if (!$done[self::USAGE_TYPE]) {
				$results[self::USAGE_TYPE] = $this->readUsageType($pointer);
				$done[self::USAGE_TYPE] = true;
			}
			break;

		case self::ASN:
			if (!$done[self::ASN]) {
				$results[self::ASN] = $this->readAsn($pointer);
				$done[self::ASN] = true;
			}
			break;

		case self::_AS:
			if (!$done[self::_AS]) {
				$results[self::_AS] = $this->readAs($pointer);
				$done[self::_AS] = true;
			}
			break;

		case self::LAST_SEEN:
			if (!$done[self::LAST_SEEN]) {
				$results[self::LAST_SEEN] = $this->readLastSeen($pointer);
				$done[self::LAST_SEEN] = true;
			}
			break;

		case self::IP_ADDRESS:
			if (!$done[self::IP_ADDRESS]) {
				$results[self::IP_ADDRESS] = $ip;
				$done[self::IP_ADDRESS] = true;
			}
			break;
		case self::IP_VERSION:
			if (!$done[self::IP_VERSION]) {
				$results[self::IP_VERSION] = $ipVersion;
				$done[self::IP_VERSION] = true;
			}
			break;
		case self::IP_NUMBER:
			if (!$done[self::IP_NUMBER]) {
				$results[self::IP_NUMBER] = $ipNumber;
				$done[self::IP_NUMBER] = true;
			}
			break;

		default:
			$results[$afield] = self::FIELD_NOT_KNOWN;
		}
		}

		// If we were asked for an array, or we have multiple results to return...
		if (is_array($fields) || count($results) > 1) {
			// return array
			if ($asNamed) {
				// apply translations if needed
				$return = [];
				foreach ($results as $key => $val) {
					if (array_key_exists($key, static::$names)) {
						$return[static::$names[$key]] = $val;
					} else {
						$return[$key] = $val;
					}
				}

				return $return;
			}

			return $results;
		}
		// return a single value
		return array_values($results)[0];
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Static tools  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Get memory limit from the current PHP settings (return false if no memory limit set).
	 *
	 * @static
	 *
	 * @return bool|int
	 */
	private static function getMemoryLimit()
	{
		// Get values if no cache
		if (self::$memoryLimit === null) {
			$limit = ini_get('memory_limit');

			// Feal with defaults
			if ((string) $limit === '') {
				$limit = '128M';
			}

			$value = (int) $limit;

			// Deal with "no-limit"
			if ($value < 0) {
				$value = false;
			} else {
				// Deal with shorthand bytes
				switch (strtoupper(substr($limit, -1))) {
			case 'G': $value *= 1024;
			// no break
			case 'M': $value *= 1024;
			// no break
			case 'K': $value *= 1024;
		}
			}
			self::$memoryLimit = $value;
		}

		return self::$memoryLimit;
	}

	/**
	 * Return the realpath of the given file or look for the first matching database option.
	 *
	 * @param string $file File to try to find, or null to try the databases in turn on the current file's path
	 *
	 * @throws \Exception
	 *
	 * @return string
	 */
	private static function findFile($file = null)
	{
		if ($file !== null) {
			// Get actual file path
			$rfile = realpath($file);

			// If the file cannot be found, except away
			if ($rfile === false) {
				throw new \Exception(__CLASS__ . ": Database file '{$file}' does not seem to exist.", self::EXCEPTION_DBFILE_NOT_FOUND);
			}

			return $rfile;
		}
		// Try to get current path
		$current = realpath(__DIR__);

		if ($current === false) {
			throw new \Exception(__CLASS__ . ': Cannot determine current path.', self::EXCEPTION_NO_PATH);
		}
		// Try each database in turn
		foreach (self::$databases as $database) {
			$rfile = realpath("{$current}/{$database}.BIN");
			if ($rfile !== false) {
				return $rfile;
			}
		}
		// No candidates found
		throw new \Exception(__CLASS__ . ': No candidate database files found.', self::EXCEPTION_NO_CANDIDATES);
	}

	/**
	 * Make the given number positive by wrapping it to 8 bit values.
	 *
	 * @static
	 *
	 * @param int $x Number to wrap
	 *
	 * @return int
	 */
	private static function wrap8($x)
	{
		return $x + ($x < 0 ? 256 : 0);
	}

	/**
	 * Make the given number positive by wrapping it to 32 bit values.
	 *
	 * @static
	 *
	 * @param int $x Number to wrap
	 *
	 * @return int
	 */
	private static function wrap32($x)
	{
		return $x + ($x < 0 ? 4294967296 : 0);
	}

	/**
	 * Generate a unique and repeatable shared memory key for each instance to use.
	 *
	 * @static
	 *
	 * @param string $filename Filename of the BIN file
	 *
	 * @return int
	 */
	private static function getShmKey($filename)
	{
		// This will create a shared memory key that deterministically depends only on
		// the current file's path and the BIN file's path
		return (int) sprintf('%u', self::wrap32(crc32(__FILE__ . ':' . $filename)));
	}

	/**
	 * Determine whether the given IP number of the given version lies between the given bounds.
	 *
	 * This function will return 0 if the given ip number falls within the given bounds
	 * for the given version, -1 if it falls below, and 1 if it falls above.
	 *
	 * @static
	 *
	 * @param int        $version IP version to use (either 4 or 6)
	 * @param int|string $ip      IP number to check (int for IPv4, string for IPv6)
	 * @param int|string $low     Lower bound (int for IPv4, string for IPv6)
	 * @param int|string $high    Uppoer bound (int for IPv4, string for IPv6)
	 *
	 * @return int
	 */
	private static function ipBetween($version, $ip, $low, $high)
	{
		if ($version === 4) {
			// Use normal PHP ints
			if ($low <= $ip) {
				if ($ip < $high) {
					return 0;
				}

				return 1;
			}

			return -1;
		}
		// Use BCMath
		if (bccomp($low, $ip, 0) <= 0) {
			if (bccomp($ip, $high, 0) <= -1) {
				return 0;
			}

			return 1;
		}

		return -1;
	}

	/**
	 * Get the IP version and number of the given IP address.
	 *
	 * This method will return an array, whose components will be:
	 * - first: 4 if the given IP address is an IPv4 one, 6 if it's an IPv6 one,
	 *          or fase if it's neither.
	 * - second: the IP address' number if its version is 4, the number string if
	 *           its version is 6, false otherwise.
	 *
	 * @static
	 *
	 * @param string $ip IP address to extract the version and number for
	 *
	 * @return array
	 */
	private static function ipVersionAndNumber($ip)
	{
		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			return [4, sprintf('%u', ip2long($ip))];
		} elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			$result = 0;

			foreach (str_split(bin2hex(inet_pton($ip)), 8) as $word) {
				$result = bcadd(bcmul($result, '4294967296', 0), self::wrap32(hexdec($word)), 0);
			}

			return [6, $result];
		}
		// Invalid IP address, return falses
		return [false, false];
	}

	/**
	 * Return the decimal string representing the binary data given.
	 *
	 * @static
	 *
	 * @param string $data Binary data to parse
	 *
	 * @return string
	 */
	private static function bcBin2Dec($data)
	{
		$parts = [
	unpack('V', substr($data, 12, 4)),
	unpack('V', substr($data, 8, 4)),
	unpack('V', substr($data, 4, 4)),
	unpack('V', substr($data, 0, 4)),
  ];

		foreach ($parts as &$part) {
			if ($part[1] < 0) {
				$part[1] += 4294967296;
			}
		}

		$result = bcadd(bcadd(bcmul($parts[0][1], bcpow(4294967296, 3)), bcmul($parts[1][1], bcpow(4294967296, 2))), bcadd(bcmul($parts[2][1], 4294967296), $parts[3][1]));

		return $result;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Caching backend abstraction  /////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Low level read function to abstract away the caching mode being used.
	 *
	 * @param int $pos Position from where to start reading
	 * @param int $len Read this many bytes
	 *
	 * @return string
	 */
	private function read($pos, $len)
	{
		switch ($this->mode) {
		case self::SHARED_MEMORY:
		return shmop_read($this->resource, $pos, $len);

		case self::MEMORY_CACHE:
		return $data = substr(self::$buffer[$this->resource], $pos, $len);

		default:
		fseek($this->resource, $pos, SEEK_SET);

		return fread($this->resource, $len);
	}
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Low-level read functions  ////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Low level function to fetch a string from the caching backend.
	 *
	 * @param int $pos        Position to read from
	 * @param int $additional Additional offset to apply
	 *
	 * @return string
	 */
	private function readString($pos, $additional = 0)
	{
		// Get the actual pointer to the string's head
		$spos = $this->readWord($pos) + $additional;

		// Read as much as the length (first "string" byte) indicates
		return $this->read($spos + 1, $this->readByte($spos + 1));
	}

	/**
	 * Low level function to fetch a float from the caching backend.
	 *
	 * @param int $pos Position to read from
	 *
	 * @return float
	 */
	private function readFloat($pos)
	{
		// Unpack a float's size worth of data
		return unpack('f', $this->read($pos - 1, self::$floatSize))[1];
	}

	/**
	 * Low level function to fetch a quadword (128 bits) from the caching backend.
	 *
	 * @param int $pos Position to read from
	 *
	 * @return string
	 */
	private function readQuad($pos)
	{
		// Use BCMath ints to get a quad's (128-bit) value
		return self::bcBin2Dec($this->read($pos - 1, 16));
	}

	/**
	 * Low level function to fetch a word (32 bits) from the caching backend.
	 *
	 * @param int $pos Position to read from
	 *
	 * @return int
	 */
	private function readWord($pos)
	{
		// Unpack a long's worth of data
		return self::wrap32(unpack('V', $this->read($pos - 1, 4))[1]);
	}

	/**
	 * Low level function to fetch a byte from the caching backend.
	 *
	 * @param int $pos Position to read from
	 *
	 * @return string
	 */
	private function readByte($pos)
	{
		// Unpack a byte's worth of data
		return self::wrap8(unpack('C', $this->read($pos - 1, 1))[1]);
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  High-level read functions  ///////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * High level function to fetch the country name and code.
	 *
	 * @param bool|int $pointer Position to read from, if false, return self::INVALID_IP_ADDRESS
	 *
	 * @return array
	 */
	private function readCountryNameAndCode($pointer)
	{
		if ($pointer === false) {
			// Deal with invalid IPs
			$countryCode = self::INVALID_IP_ADDRESS;
			$countryName = self::INVALID_IP_ADDRESS;
		} elseif (0 === self::$columns[self::COUNTRY_CODE][$this->type]) {
			// If the field is not suported, return accordingly
			$countryCode = self::FIELD_NOT_SUPPORTED;
			$countryName = self::FIELD_NOT_SUPPORTED;
		} else {
			// Read the country code and name (the name shares the country's pointer,
			// but it must be artificially displaced 3 bytes ahead: 2 for the country code, one
			// for the country name's length)
			$countryCode = $this->readString($pointer + self::$columns[self::COUNTRY_CODE][$this->type]);
			$countryName = $this->readString($pointer + self::$columns[self::COUNTRY_NAME][$this->type], 3);
		}

		return [$countryName, $countryCode];
	}

	/**
	 * High level function to fetch the region name.
	 *
	 * @param int $pointer Position to read from, if false, return self::INVALID_IP_ADDRESS
	 *
	 * @return string
	 */
	private function readRegionName($pointer)
	{
		if ($pointer === false) {
			// Deal with invalid IPs
			$regionName = self::INVALID_IP_ADDRESS;
		} elseif (0 === self::$columns[self::REGION_NAME][$this->type]) {
			// If the field is not suported, return accordingly
			$regionName = self::FIELD_NOT_SUPPORTED;
		} else {
			// Read the region name
			$regionName = $this->readString($pointer + self::$columns[self::REGION_NAME][$this->type]);
		}

		return $regionName;
	}

	/**
	 * High level function to fetch the city name.
	 *
	 * @param int $pointer Position to read from, if false, return self::INVALID_IP_ADDRESS
	 *
	 * @return string
	 */
	private function readCityName($pointer)
	{
		if ($pointer === false) {
			// Deal with invalid IPs
			$cityName = self::INVALID_IP_ADDRESS;
		} elseif (0 === self::$columns[self::CITY_NAME][$this->type]) {
			// If the field is not suported, return accordingly
			$cityName = self::FIELD_NOT_SUPPORTED;
		} else {
			// Read the city name
			$cityName = $this->readString($pointer + self::$columns[self::CITY_NAME][$this->type]);
		}

		return $cityName;
	}

	/**
	 * High level function to fetch the ISP name.
	 *
	 * @param int $pointer Position to read from, if false, return self::INVALID_IP_ADDRESS
	 *
	 * @return string
	 */
	private function readIsp($pointer)
	{
		if ($pointer === false) {
			// Deal with invalid IPs
			$isp = self::INVALID_IP_ADDRESS;
		} elseif (0 === self::$columns[self::ISP][$this->type]) {
			// If the field is not suported, return accordingly
			$isp = self::FIELD_NOT_SUPPORTED;
		} else {
			// Read isp name
			$isp = $this->readString($pointer + self::$columns[self::ISP][$this->type]);
		}

		return $isp;
	}

	/**
	 * High level function to fetch the proxy type.
	 *
	 * @param int $pointer Position to read from, if false, return self::INVALID_IP_ADDRESS
	 *
	 * @return string
	 */
	private function readProxyType($pointer)
	{
		if ($pointer === false) {
			// Deal with invalid IPs
			$proxyType = self::INVALID_IP_ADDRESS;
		} elseif (0 === self::$columns[self::PROXY_TYPE][$this->type]) {
			// If the field is not suported, return accordingly
			$proxyType = self::FIELD_NOT_SUPPORTED;
		} else {
			// Read proxy type
			$proxyType = $this->readString($pointer + self::$columns[self::PROXY_TYPE][$this->type]);
		}

		return $proxyType;
	}

	/**
	 * High level function to fetch the domain.
	 *
	 * @param int $pointer Position to read from, if false, return self::INVALID_IP_ADDRESS
	 *
	 * @return string
	 */
	private function readDomain($pointer)
	{
		if ($pointer === false) {
			// Deal with invalid IPs
			$domain = self::INVALID_IP_ADDRESS;
		} elseif (0 === self::$columns[self::DOMAIN][$this->type]) {
			// If the field is not suported, return accordingly
			$domain = self::FIELD_NOT_SUPPORTED;
		} else {
			// Read the domain
			$domain = $this->readString($pointer + self::$columns[self::DOMAIN][$this->type]);
		}

		return $domain;
	}

	/**
	 * High level function to fetch the usage type.
	 *
	 * @param int $pointer Position to read from, if false, return self::INVALID_IP_ADDRESS
	 *
	 * @return string
	 */
	private function readUsageType($pointer)
	{
		if ($pointer === false) {
			// Deal with invalid IPs
			$usageType = self::INVALID_IP_ADDRESS;
		} elseif (0 === self::$columns[self::USAGE_TYPE][$this->type]) {
			// If the field is not suported, return accordingly
			$usageType = self::FIELD_NOT_SUPPORTED;
		} else {
			// Read the domain
			$usageType = $this->readString($pointer + self::$columns[self::USAGE_TYPE][$this->type]);
		}

		return $usageType;
	}

	/**
	 * High level function to fetch the ASN.
	 *
	 * @param int $pointer Position to read from, if false, return self::INVALID_IP_ADDRESS
	 *
	 * @return string
	 */
	private function readAsn($pointer)
	{
		if ($pointer === false) {
			// Deal with invalid IPs
			$asn = self::INVALID_IP_ADDRESS;
		} elseif (0 === self::$columns[self::ASN][$this->type]) {
			// If the field is not suported, return accordingly
			$asn = self::FIELD_NOT_SUPPORTED;
		} else {
			// Read the domain
			$asn = $this->readString($pointer + self::$columns[self::ASN][$this->type]);
		}

		return $asn;
	}

	/**
	 * High level function to fetch the AS.
	 *
	 * @param int $pointer Position to read from, if false, return self::INVALID_IP_ADDRESS
	 *
	 * @return string
	 */
	private function readAs($pointer)
	{
		if ($pointer === false) {
			// Deal with invalid IPs
			$as = self::INVALID_IP_ADDRESS;
		} elseif (0 === self::$columns[self::_AS][$this->type]) {
			// If the field is not suported, return accordingly
			$as = self::FIELD_NOT_SUPPORTED;
		} else {
			// Read the domain
			$as = $this->readString($pointer + self::$columns[self::_AS][$this->type]);
		}

		return $as;
	}

	/**
	 * High level function to fetch the Last seen.
	 *
	 * @param int $pointer Position to read from, if false, return self::INVALID_IP_ADDRESS
	 *
	 * @return string
	 */
	private function readLastSeen($pointer)
	{
		if ($pointer === false) {
			// Deal with invalid IPs
			$lastSeen = self::INVALID_IP_ADDRESS;
		} elseif (0 === self::$columns[self::LAST_SEEN][$this->type]) {
			// If the field is not suported, return accordingly
			$lastSeen = self::FIELD_NOT_SUPPORTED;
		} else {
			// Read the domain
			$lastSeen = $this->readString($pointer + self::$columns[self::LAST_SEEN][$this->type]);
		}

		return $lastSeen;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//  Binary search and support functions  /////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * High level fucntion to read an IP address of the given version.
	 *
	 * @param int $version IP version to read (either 4 or 6, returns false on anything else)
	 * @param int $pos     Position to read from
	 *
	 * @return bool|int|string
	 */
	private function readIp($version, $pos)
	{
		if ($version === 4) {
			// Read a standard PHP int
			return self::wrap32($this->readWord($pos));
		} elseif ($version === 6) {
			// Read as BCMath int (quad)
			return $this->readQuad($pos);
		}
		// unrecognized
		return false;
	}

	/**
	 * Perform a binary search on the given IP number and return a pointer to its record.
	 *
	 * @param int $version  IP version to use for searching
	 * @param int $ipNumber IP number to look for
	 *
	 * @return bool|int
	 */
	private function binSearch($version, $ipNumber)
	{
		if ($version === false) {
			// unrecognized version
			return false;
		}

		// initialize fields
		$base = $this->ipBase[$version];
		$offset = $this->offset[$version];
		$width = $this->columnWidth[$version];
		$high = $this->ipCount[$version];
		$low = 0;

		//hjlim
		$indexBaseStart = $this->indexBaseAddr[$version];
		if ($indexBaseStart > 0) {
			$indexPos = 0;
			switch ($version) {
		case 4:
		$ipNum1_2 = (int) ($ipNumber / 65536);
		$indexPos = $indexBaseStart + ($ipNum1_2 << 3);

		break;

		case 6:
		$ipNum1 = (int) (bcdiv($ipNumber, bcpow('2', '112')));
		$indexPos = $indexBaseStart + ($ipNum1 << 3);

		break;

		default:
		return false;
	}

			$low = $this->readWord($indexPos);
			$high = $this->readWord($indexPos + 4);
		}

		// as long as we can narrow down the search...
		while ($low <= $high) {
			$mid = (int) ($low + (($high - $low) >> 1));

			// Read IP ranges to get boundaries
			$ip_from = $this->readIp($version, $base + $width * $mid);
			$ip_to = $this->readIp($version, $base + $width * ($mid + 1));

			// determine whether to return, repeat on the lower half, or repeat on the upper half
			switch (self::ipBetween($version, $ipNumber, $ip_from, $ip_to)) {
		case 0:
		return $base + $offset + $mid * $width;
		case -1:
			$high = $mid - 1;
			break;
		case 1:
			$low = $mid + 1;
			break;
		}
		}

		// nothing found
		return false;
	}
}
