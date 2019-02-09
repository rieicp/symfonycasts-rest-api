<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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

		$response = new Response('It worked. Believe me - I\'m an API', 201);
		$response->headers->set('Location', '/some/programmer/url');

		return $response;
	}


	/**
	* @Route("/api/programmers/{nickname}")
	* @Method("GET")
	*/
	public function showAction($nickname)
	{
		$programmer = $this->getDoctrine()
			->getRepository('AppBundle:Programmer')
			->findOneByNickname($nickname);

		$data = array(
			'nickname' => $programmer->getNickname(),
			'avatarNumber' => $programmer->getAvatarNumber(),
			'powerLevel' => $programmer->getPowerLevel(),
			'tagLine' => $programmer->getTagLine(),
		);

		return new Response(json_encode($data), 200);
	}
}
