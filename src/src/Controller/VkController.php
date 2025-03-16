<?php

namespace App\Controller;

use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VkController extends AbstractController
{
    #[Route('/api/vk', name: 'vk', methods: ['GET'])]
    public function vk()
    {
//        getenv()
        return new Response("Lox");
//        return $this->render('vk/index.html.twig');
    }

//    #[Route('/oauth/vk/check/', name: 'check')]
//    public function connectCheckAction(Request $request)
//    {
//
//    }
}
