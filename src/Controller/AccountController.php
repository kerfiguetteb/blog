<?php

namespace App\Controller;

use App\Entity\Post;
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
                // 'post'=>$post
            ]);
        }else {
            $this->redirectToRoute('app_login');   
        }
    }

    #[Route('/delete-post/{id}', name: 'app_delete_post')]
    public function deletePost($id,PostRepository $repos): Response
    {
        $post = $repos->find($id);
        $post->setVisibilite(false);
        $repos->save($post, true);
        return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);    }
}
