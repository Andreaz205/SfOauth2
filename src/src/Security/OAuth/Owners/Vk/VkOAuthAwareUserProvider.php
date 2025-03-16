<?php

namespace App\Security\OAuth\Owners\Vk;

use App\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class VkOAuthAwareUserProvider implements OAuthAwareUserProviderInterface
{
    public function loadUserByOAuthUserResponse(UserResponseInterface $response): UserInterface
    {
        if (!$response->getEmail()) {
            throw new \Exception("Email not set for user!");
        }

        $user = new User();

        $user->setEmail($response->getEmail());
        $user->setFirstName($response->getFirstName());
        $user->setLastName($response->getLastName());
        $user->setPicture($response->getProfilePicture());
        $user->setUsername($response->getNickname() ?? $response->getData()['response']['screen_name']);
        $user->setVkId($response->getUserIdentifier() ?? $response->getData()['response']['id']);

        return $user;
    }
}