<?php

namespace App\Security\OAuth\Owners\Vk;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class SuccessHandler extends AuthenticationSuccessHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        JWTTokenManagerInterface $jwtManager,
        EventDispatcherInterface $dispatcher,
        iterable $cookieProviders = [],
        bool $removeTokenFromBodyWhenCookiesUsed = true
    ){
        parent::__construct($jwtManager, $dispatcher, $cookieProviders, $removeTokenFromBodyWhenCookiesUsed);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): Response
    {
        /** @var User $user */
        $user = $token->getUser();

        if (!$this->userRepository->findBy(['email' => $user->getEmail()])) {
            $this->userRepository->create($user);
        }

        return $this->handleAuthenticationSuccess($token->getUser());
    }
}
