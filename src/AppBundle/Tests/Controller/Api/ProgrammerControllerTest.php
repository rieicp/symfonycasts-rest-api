<?php
namespace AppBundle\Tests\Controller\Api;

use AppBundle\Test\ApiTestCase;

class ProgrammerControllerTest extends ApiTestCase
{
	public function testPOST()
	{
		// 1) Create a programmer resource
		$data = array(
			'nickname' => 'ObjectOrienter',
			'avatarNumber' => 5,
			'tagLine' => 'a test dev!'
		);

		$response = $this->client->post('/api/programmers', [
			'body' => json_encode($data)
		]);

		$this->assertEquals(201, $response->getStatusCode());
		$this->assertEquals('/api/programmers/ObjectOrienter', $response->getHeader('Location'));
		$finishedData = json_decode($response->getBody(true), true);

		$this->assertArrayHasKey('nickname', $finishedData);
		$this->assertEquals('ObjectOrienter', $finishedData['nickname']);
	}
}
