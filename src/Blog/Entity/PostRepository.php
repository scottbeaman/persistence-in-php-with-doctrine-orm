<?php

namespace Blog\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    /**
     * Finds a post with its comments
     *
     * @param  int  $id
     * @return Post
     */
    public function findWithComments($id)
    {
        return $this
            ->createQueryBuilder('p')
            ->addSelect('c')
            ->leftJoin('p.comments', 'c')
            ->where('p.id = :id')
            ->orderBy('c.publicationDate', 'ASC')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * Finds posts having tags
     *
     * @param string[] $tagNames
     * @return Post[]
     */
    public function findHavingTags(array $tagNames)
    {
        return $queryBuilder = $this
            ->createQueryBuilder('p')
            ->addSelect('t')
            ->addSelect('COUNT(c.id)')
            ->leftJoin('p.comments', 'c')
            ->join('p.tags', 't')
            ->where('t.name IN (:tagNames)')
            ->groupBy('p.id')
            ->having('COUNT(t.name) >= :numberOfTags')
            ->setParameter('tagNames', $tagNames)
            ->setParameter('numberOfTags', count($tagNames))
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Finds posts with comment count
     *
     * @return array
     */
    public function findWithCommentCount()
    {
        return $this
            ->createQueryBuilder('p')
            ->leftJoin('p.comments', 'c')
            ->addSelect('COUNT(c.id)')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult()
            ;
    }
}
