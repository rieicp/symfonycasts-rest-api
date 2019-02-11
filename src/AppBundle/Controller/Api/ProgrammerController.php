<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Programmer;
use AppBundle\Form\ProgrammerType;

class ProgrammerController extends BaseController
{
   /**
	* @Route("/api/programmers")
	* @Method("POST")
	*/
	public function newAction(Request $request)
	{

		$data = json_decode($request->getContent(), true);
		
		$programmer = new Programmer();
		$form = $this->createForm(new ProgrammerType(), $programmer);
		$form->submit($data);
		$programmer->setUser($this->findUserByUsername('weaverryan'));

		$em = $this->getDoctrine()->getManager();
		$em->persist($programmer);
		$em->flush();

		$data = $this->serializeProgrammer($programmer);
		$response = new JsonResponse($data, 201);
		$response->headers->set('Content-Type', 'application/json');

		$programmerUrl = $this->generateUrl(
			'api_programmers_show',
			['nickname' => $programmer->getNickname()]
		);
		$response->headers->set('Location', $programmerUrl);
		return $response;
	}


   /**
	* @Route("/api/programmers/{nickname}", name="api_programmers_show")
	* @Method("GET")
	*/
	public function showAction($nickname)
	{
		$programmer = $this->getDoctrine()
			->getRepository('AppBundle:Programmer')
			->findOneByNickname($nickname);

		if (!$programmer) {
			throw $this->createNotFoundException(sprintf(
				'No programmer found with nickname "%s"',
				$nickname
			));
		}

		$data = $this->serializeProgrammer($programmer);

		$response = new JsonResponse($data, 200);
		$response->headers->set('Content-Type', 'application/json');

		return $response;
	}

   /**
	* @Route("/api/programmers")
	* @Method("GET")
	*/
	public function listAction()
	{
		$programmers = $this->getDoctrine()
			->getRepository('AppBundle:Programmer')
			->findAll();

		$data = array('programmers' => array());

		foreach ($programmers as $programmer) {
			$data['programmers'][] = $this->serializeProgrammer($programmer);
		}
	
		$response = new JsonResponse($data, 200);
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	private function serializeProgrammer(Programmer $programmer)
	{
		return array(
			'nickname' => $programmer->getNickname(),
			'avatarNumber' => $programmer->getAvatarNumber(),
			'powerLevel' => $programmer->getPowerLevel(),
			'tagLine' => $programmer->getTagLine(),
		);
	}

}
