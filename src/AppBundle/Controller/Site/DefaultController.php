<?php

namespace AppBundle\Controller\Site;

use AppBundle\Form\Type\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(CommentType::class);

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
