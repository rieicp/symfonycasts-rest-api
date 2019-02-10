<?php

namespace AppBundle\Test;

class ApiTestCase extends \PHPUnit_Framework_TestCase
{
	private static $staticClient;
	protected $client;

	public static function setUpBeforeClass()
	{
		self::$staticClient = new \GuzzleHttp\Client([
		    'base_url' => 'http://localhost:8000',
		    // 'base_uri' => 'http://localhost:8000',
			'defaults' => [
		        'exceptions' => false
		    ]
		    // 'http_errors' => false
		]);

	}

	protected function setUp()
	{
		$this->client = self::$staticClient;
	}
	
}

