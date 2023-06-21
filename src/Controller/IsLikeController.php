<?php

namespace App\Controller;

use App\Entity\IsLike;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IsLikeController extends AbstractController
{
    #[Route('/islike', name: 'app_is_like')]
    public function index(): Response
    {
        $like = new IsLike();
        return $this->render('isLike/index.html.twig', [
            'like'=>$like,
        ]);
    }
}
