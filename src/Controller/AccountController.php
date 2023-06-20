<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class AccountController extends AbstractController
{
    #[Route('', name: 'app_account')]
    public function index(PostRepository $repos): Response
    {
        if ($this->getUser()) {
            return $this->render('account/index.html.twig',[
                'posts'=>$repos->findByUser($this->getUser()),
            ]);
        }else {
            $this->redirectToRoute('app_login');   
        }
    }

}
