<?php

namespace App\Controller;

use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

#[Route('profile')]
class PostController extends AbstractController
{
    private $repoPost;

    public function __construct(PostRepository $postRepository,)
    {
        $this->repoPost = $postRepository;
    }

    #[Route('/edit-post/{id}', name: 'app_edit_post', methods: ['GET', 'POST'])]
    public function editPost($id,Request $request): Response
    {
        $post=$this->repoPost->find($id);
        
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repoPost->save($post, true);

            return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete-post/{id}', name: 'app_delete_post')]
    public function deletePost($id): Response
    {
        $post = $this->repoPost->find($id);
        $post->setVisibilite(false);
        $this->repoPost->save($post, true);
        return $this->redirectToRoute('app_account', [], Response::HTTP_SEE_OTHER);  
    }

}
