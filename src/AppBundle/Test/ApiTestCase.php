<?php

namespace AppBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class ApiTestCase extends KernelTestCase
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

		self::bootKernel();
	}

	protected function setUp()
	{
		$this->client = self::$staticClient;
		$this->purgeDatabase();
	}


	protected function tearDown()
	{
		//Purposefully not calling methods, which shuts down the kernel.
		//Normally, the base class actually shuts down the kernel in tearDown() . 
		//What I'm doing - on purpose - is booting the kernel and creating the 
		//container just once per my whole test suite.
		//That'll make things faster, though in theory it could cause issues or 
		//even slow things down eventually. You can experiment by shutting down 
		//your kernel in tearDown() and booting it in setup() if you want.
	}

	protected function getService($id)
	{
		return self::$kernel->getContainer()->get($id);
	}

	private function purgeDatabase()
	{
		$purger = new ORMPurger($this->getService('doctrine')->getManager());
		$purger->purge();
	}

}
