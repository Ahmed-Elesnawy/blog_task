<?php

namespace App\Controller\Dashboard;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="dashboard_post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('dashboard/post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dashboard_post_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($post);
            $entityManager->flush();
            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('dashboard_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('dashboard/post/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dashboard_post_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Saved');
            return $this->redirectToRoute('dashboard_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_post_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager->remove($post);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Saved');

        return $this->redirectToRoute('dashboard_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
