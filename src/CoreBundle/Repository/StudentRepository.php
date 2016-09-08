<?php

namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;


class StudentRepository extends EntityRepository
{
    /**
     * returns an array of student objects based on entered values in the student search
     *
     * @param array $searchTerms
     * @param null $advisor
     * @param null $topic
     * @return array
     */
    public function getSearchResult($searchTerms = null, $advisor = null, $topic = null)
    {
        $query = $this->getEntityManager()->createQueryBuilder('s')
            ->select('s')
            ->from('CoreBundle:Student', 's')
            ->innerJoin('s.projectGroup', 'g');

            if ($advisor != null) {
                $query->andWhere('g.advisor = :advisor')
                    ->setParameter('advisor', $advisor);
            }

            if ($topic != null) {
                $query->andWhere('g.topic = :topic')
                    ->setParameter('topic', $topic);
            }

            foreach ($searchTerms as $searchTerm) {
                if ($searchTerm) {
                    $query->andWhere('s.name LIKE :term')
                        ->setParameter('term', '%' . $searchTerm . '%');
                }
            }

        $result = $query->getQuery();

        return $result->getResult();
    }
}
