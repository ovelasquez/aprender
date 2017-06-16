<?php

namespace AppBundle\Security\Authentication\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Doctrine\ORM\EntityManager;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $security;
    protected $em;

    public function __construct(Router $router, AuthorizationCheckerInterface $security, EntityManager $em) {
        $this->router = $router;
        $this->security = $security;
        $this->em = $em;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {

        $response = null;

        // retrieve user and session id
        $user = $token->getUser();

        if (!empty($request->request->get('_target_path'))):
            $referer = $request->request->get('_target_path');
        else:
            $referer = '';
        endif;

        if ($referer === '') {
            if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
                $response = new RedirectResponse($this->router->generate('courses_index_list'));
            } else {
                $response = new RedirectResponse($this->router->generate('homepage'));
            }
        } else {
            $response = new RedirectResponse($referer);
        }

        return $response;
    }

}
