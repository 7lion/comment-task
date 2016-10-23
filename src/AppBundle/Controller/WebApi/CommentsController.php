<?php

namespace AppBundle\Controller\WebApi;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Entity\UserRepository;
use AppBundle\Form\Type\CommentType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentsController extends FOSRestController implements ClassResourceInterface
{
    public function postAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->view(['message' => 'You can access this only using Ajax!'], Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();

        /** @var UserRepository $userRepository */
        $userRepository = $em->getRepository(User::class);

        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var Comment $comment */
            $comment = $form->getData();
            $user = $comment->getUser();

            $existUser = $userRepository->findByEmail($user->getEmail());
            if ($existUser) {
                $comment->setUser($existUser);
            }

            $em->persist($comment);
            $em->flush();

            return $this->view($comment);
        }

        return $this->view(
            $this->get('form_error_serializer')->serializeFormErrors($form),
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    public function cgetAction()
    {
        $em = $this->getDoctrine()->getManager();

        /** @var UserRepository $userRepository */
        $repository = $em->getRepository(Comment::class);

        return $this->view($repository->findAll());
    }
}
