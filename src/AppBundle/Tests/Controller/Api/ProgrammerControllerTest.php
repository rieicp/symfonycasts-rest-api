<?php
namespace AppBundle\Tests\Controller\Api;

use AppBundle\Test\ApiTestCase;
use Symfony\Component\PropertyAccess\PropertyAccess;
use AppBundle\Entity\Programmer;

class ProgrammerControllerTest extends ApiTestCase
{
	protected function setUp()
    {
    	parent::setUp();

        $this->createUser('weaverryan');
    }

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
		$this->assertStringEndsWith('/api/programmers/ObjectOrienter', $response->getHeader('Location'));
		$finishedData = json_decode($response->getBody(true), true);

		$this->assertArrayHasKey('nickname', $finishedData);
		$this->assertEquals('ObjectOrienter', $finishedData['nickname']);
	}

	public function testGETProgrammer()
	{
		$this->createProgrammer(array(
			'nickname' => 'UnitTester',
			'avatarNumber' => 3,
		));

		$response = $this->client->get('/api/programmers/UnitTester');
		$this->assertEquals(200, $response->getStatusCode());
		$this->asserter()->assertResponsePropertiesExist($response, array(
			'nickname',
			'avatarNumber',
			'powerLevel',
			'tagLine'
		));
		$this->asserter()->assertResponsePropertyEquals($response, 'nickname', 'UnitTester');
	}

	public function testGETProgrammersCollection()
	{
		$this->createProgrammer(array(
			'nickname' => 'UnitTester',
			'avatarNumber' => 3,
		));

		$this->createProgrammer(array(
			'nickname' => 'CowboyCoder',
			'avatarNumber' => 5,
		));

		$response = $this->client->get('/api/programmers');
		$this->assertEquals(200, $response->getStatusCode());
		$this->asserter()->assertResponsePropertyIsArray($response, 'programmers');
		$this->asserter()->assertResponsePropertyCount($response, 'programmers', 2);
		$this->asserter()->assertResponsePropertyEquals($response, 'programmers[1].nickname', 'CowboyCoder');
	}

	protected function createProgrammer(array $data)
	{
		$data = array_merge(array(
					'powerLevel' => rand(0, 10),
					'user' => $this->getEntityManager()
						->getRepository('AppBundle:User')
						->findAny()
					), $data);

		$accessor = PropertyAccess::createPropertyAccessor();
		$programmer = new Programmer();
		foreach ($data as $key => $value) {
			$accessor->setValue($programmer, $key, $value);
		}

		$this->getEntityManager()->persist($programmer);
		$this->getEntityManager()->flush();
		return $programmer;
	}

}