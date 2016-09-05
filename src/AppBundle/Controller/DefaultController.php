<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
//        $user = $this->getUser();
//        if (!($user instanceof UserInterface)) {
//            return $this->redirectToRoute('login');
//        } else {

//            $user = $this->get('security.token_storage')->getToken()->getUser();
//
//            var_dump($user);
//            exit;

            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            ]);
//        }
    }



    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $user = $this->getUser();
        if ($user instanceof UserInterface) {
            return $this->redirectToRoute('homepage');
        }

        /** @var AuthenticationException $exception */
        $exception = $this->get('security.authentication_utils')
            ->getLastAuthenticationError();

        return $this->render('default/login.html.twig', [
            'error' => $exception ? $exception->getMessage() : NULL,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
        // Nothing needed.
    }
}
