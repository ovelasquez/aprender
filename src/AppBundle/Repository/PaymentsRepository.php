<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * Description of PaymentsRepository
 *
 * @author Mariana Flores
 */
class PaymentsRepository extends EntityRepository {

    public function findByCourseUser($user) {
        $query = $this->getEntityManager()
                ->createQuery(
                'SELECT c as course, SUM(p.amount) as tota, count(p) as tots 
                    FROM AppBundle:Courses c 
                    LEFT JOIN AppBundle:Payments p 
                    WITH p.course=c.id  
                    WHERE c.user =:user and p.id is not NULL 
                    group by c.id'
        );
        $query->setParameter('user', $user);

        $entities = $query->getResult();
        
        return $entities;
    }

    public function findByCourseUserMonth($user) {
//        $query = $this->getEntityManager()
//                ->createQuery(
//                'SELECT MONTH(p.pdatetime) as gMonth, SUM(p.amount) as tota,count(p) as tots FROM AppBundle:Payments p LEFT JOIN AppBundle:Courses c WITH p.course=c.id  WHERE c.user =:user group by gMonth '
//        );
//        $query->setParameter('user', $user);

        return $this->getEntityManager()
                ->createQueryBuilder()
                ->select('MONTH(p.pdatetime) as gMonth, SUM(p.amount) as tota,count(p) as tots')
                ->from('AppBundle:Payments', 'p')
                ->innerJoin('p.course', 'c')
                ->where('c.user = :user')
                ->groupBy('gMonth')
                ->setParameter('user', $user->getId())
                ->getQuery()
                ->getResult();       
        
    }

}
