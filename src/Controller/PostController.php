<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('profile')]
class PostController extends AbstractController
{
    private $repoPost;
    private $repoLike;

    public function __construct(
     PostRepository $postRepository,
     LikeRepository $likeRepository
     )
    {
        $this->repoPost = $postRepository;
        $this->repoLike = $likeRepository;
    }

    #[Route('/edit-post/{id}', name: 'app_edit_post', methods: ['GET', 'POST'])]
    public function edit($id,Request $request): Response
    {
        $post=$this->repoPost->find($id);

        if ($post->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('app_account');
        }
        
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

    #[Route('/new', name:'app_add_post', methods:['GET','POST'])]
    public function add(Request $request): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setVisibilite(true);
            $post->setUser($this->getUser());
            $this->repoPost->save($post, true);


            return $this->redirectToRoute('app_account');
        }

        return $this->render('post/add.html.twig',[
            'post'=>$post,
            'form'=>$form->createView()
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

    #[Route('post/{id}/likes', name: 'app_like')]
    public function isLike($id){
        $post = $this->repoPost->find($id);
        $like = $this->repoLike->findOneBy([
            'post'=>$post,
            'user'=> $this->getUser()
        ]);
        dd($like);
        // if ($post->isLike($this->getUser())) {

        //     $this->repoLike->remove($like, true);
        //     return $this->json(['code'=> 200,'message'=>'Like supprimer']);
        // }
        return $this->json(['code'=> 200,'message'=>'Ça marche bien']);

    }

}
