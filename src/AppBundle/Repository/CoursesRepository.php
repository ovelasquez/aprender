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
 * Description of CoursesRepository
 *
 * @author Mariana Flores
 */
class CoursesRepository extends EntityRepository {

    public function findAllBy($q, $parameters,$ord="c.startdate DESC") {
        $em = $this->getEntityManager();
        $where='';            
        foreach ($parameters as $value) {  $where.=' and c.' . $value[0] . '' . $value[1] . ':' . $value[0] . ' ';  }
        $query = $em->createQuery(
                'SELECT c FROM AppBundle:Courses c'
                . ' WHERE 1=1'
                . ((isset($q) && $q !== '' ) ? ' and (c.title LIKE :q or c.resume LIKE :q or c.description LIKE :q) ' : '')
                . $where
                . ' ORDER BY '.$ord.''
        );
        if (isset($q) && $q !== ''): $query->setParameter('q', '%' . $q . '%');  endif;

        foreach ($parameters as $value) {  $query->setParameter($value[0], $value[2]);   }
        //dump($query); die();
        //$query->setParameter('nowdate', $dat);
        return $query->getResult();
    }
}
