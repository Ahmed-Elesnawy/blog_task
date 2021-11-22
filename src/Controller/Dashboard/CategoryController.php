<?php

namespace App\Controller\Dashboard;

use App\Entity\Category;
use App\Form\Category1Type;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="dashboard_category_index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('dashboard/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="dashboard_category_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Saved');
            return $this->redirectToRoute('dashboard_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/category/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_category_show", methods={"GET"})
     */
    public function show(Category $category): Response
    {
        return $this->render('dashboard/category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dashboard_category_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Saved');

            return $this->redirectToRoute('dashboard_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dashboard/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_category_delete", methods={"POST"})
     */
    public function delete(Request $request, Category $category, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
            $entityManager->remove($category);
            $entityManager->flush();
        }

        $this->addFlash('success', 'Saved');

        return $this->redirectToRoute('dashboard_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
