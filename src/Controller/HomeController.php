<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Utils\PostService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    private $postRepository;
    private $categoryRepository;

    public function __construct(PostRepository $postRepository,CategoryRepository $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        if ( !$this->getUser() ){
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home/index.html.twig', [
            'categories' => $this->categoryRepository->findAll(),
            'posts'      => $this->postRepository->publishedPostsByCategory($request->get('category')),
        ]);
    }
    /**
     * @Route("posts/{id}", name="show_post")
     */

    public function show(Request $request,$id,PostService $postService)
    {
        $comment = $postService->createCommentFromPostIdAndUser($id,$this->getUser());

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $postService->persistAndFlush($comment);

            return $this->redirect($request->getRequestUri());
        }

        return $this->render('home/show.html.twig',[
            'post' => $postService->getPost($id),
            'form' => $form->createView()
        ]);
    }


}
