<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }


    public function publishedPostsByCategory($category = null)
    {
        $builder = $this->createQueryBuilder('posts')->where('posts.is_publish = :bool')
                         ->setParameter('bool',true);

        if ( $category ){
            $builder->andWhere('posts.category_id = :category_id')->setParameter('category_id',$category);
        }

        return $builder->getQuery()->getResult();
    }

    public function findOneFromPublished($id)
    {
        return $this->createQueryBuilder('posts')
                     ->where('posts.is_publish = :bool')
                     ->andWhere('posts.id=:id')
                     ->setParameter('bool',true)
                     ->setParameter('id',$id)
                     ->getQuery()
                     ->getOneOrNullResult();
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
