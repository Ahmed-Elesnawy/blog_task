<?php

namespace App\Utils;

use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    public $entityManager;
    public $postRepository;

    public function __construct(EntityManagerInterface $entityManager,PostRepository $postRepository)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
    }

    public function createCommentFromPostIdAndUser($post_id,$user)
    {
        $comment = new Comment();
        $comment->setPost($this->getPost($post_id));
        $comment->setUser($user);
        return $comment;
    }

    public function getPost($id) : Post
    {
        return $this->postRepository->find($id);
    }


    public function persistAndFlush($object)
    {
        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }
}