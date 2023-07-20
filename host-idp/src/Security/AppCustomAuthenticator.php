<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

/** validates the auth */

class AppCustomAuthenticator extends AbstractAuthenticator
{

    private function isLocalLoginRequest(Request $request):bool{
        $isLoginPath = $request->getPathInfo() === '/login';
        $isPost = $request->isMethod('POST');
        return $isLoginPath && $isPost;
    }

    public function supports(Request $request): ?bool
    {
        return $this->isLocalLoginRequest($request);
    }

    public function authenticate(Request $request): Passport
    {

        $email = $request->request->get('email','');
        $password = $request->request->get('password','');
        return new Passport(
            new UserBadge($email),
            new CustomCredentials(function($credentials, User $user) {
                return $credentials === '123';
            }, $password)
        );

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse(
            url: '/home'
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {

        $redirectResponse =  new RedirectResponse(
            url: $request->getRequestUri(),
            status: 302
        );
        return $redirectResponse;
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
