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

		return new Response('It worked. Believe me - I\'m an API');
	}
}
