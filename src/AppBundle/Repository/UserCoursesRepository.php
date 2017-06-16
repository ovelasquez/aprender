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
 * Description of UserCoursesRepository
 *
 * @author Oscar Velasquez
 */
class UserCoursesRepository extends EntityRepository {

    public function findAllOrderedByUsers($users, $course) {
        $query = $this->getEntityManager()
                ->createQuery(
                'SELECT u.id,u.name,u.lastName,uc.status,uc.id as idr FROM AppBundle:User u  LEFT JOIN  AppBundle:UserCourses uc WITH u.id=uc.user  WHERE uc.user in (:users) and uc.course=:course'
        );
        $query->setParameter('users', $users);
        $query->setParameter('course', $course);
        $entities = $query->getResult();
        return $entities;
    }

    public function findAllOrderedByUserCompleted($user) {

        $dat = date("Y-m-d");

        $query = $this->getEntityManager()
                ->createQuery(
                'SELECT uc.status, c.title, c.id, c.resume, c.photo, c.description, c.video FROM AppBundle:User u  LEFT JOIN  AppBundle:UserCourses uc WITH u.id=uc.user LEFT JOIN  AppBundle:Courses c WITH c.id=uc.course  WHERE uc.user =:user and c.enddate<:nowdate'
        );
        $query->setParameter('user', $user);
        $query->setParameter('nowdate', $dat);
        $entities = $query->getResult();
        return $entities;
    }

    public function findAllMyCourses($user, $parameters = array(), $q = '') {

        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata('AppBundle\Entity\Courses', 'f');
        $where = '';
        foreach ($parameters as $value) {
            $where.=' and c.' . $value[0] . '' . $value[1] . ':' . $value[0] . ' ';
        }
        $query = $this->getEntityManager()
                ->createNativeQuery(
                'SELECT uc.status, c.* '
                . 'FROM lkw_user u  '
                . 'LEFT JOIN  lkw_user_courses uc ON u.id=uc.user_id '
                . 'LEFT JOIN  lkw_courses c ON c.id=uc.course_id  '
                . 'WHERE uc.user_id =:user '
                . $where
                . ((isset($q) && $q !== '' ) ? ' and (c.title LIKE :q or c.resume LIKE :q or c.description LIKE :q) ' : '')
                . ' order by c.star_date DESC', $rsm
        );
        foreach ($parameters as $value) {
            $query->setParameter($value[0], $value[2]);
        }
        $query->setParameter('user', $user);
         if (isset($q) && $q !== ''): $query->setParameter('q', '%' . $q . '%');  endif;
        $entities = $query->getResult();

        return $entities;
    }

    public function findMyCoursesToApprove($user) {

        $dat = date("Y-m-d");

        $query = $this->getEntityManager()
                ->createQuery(
                'SELECT uc.status, c.title, c.id, c.resume, c.photo, c.description, c.video '
                . 'FROM AppBundle:User u  '
                . 'LEFT JOIN  AppBundle:UserCourses uc WITH u.id=uc.user '
                . 'LEFT JOIN  AppBundle:Courses c WITH c.id=uc.course  '
                . "LEFT JOIN  AppBundle:Reviews r WITH (u.id=r.evaluator and c.id=r.evaluated and r.type='curso')  "
                . 'WHERE uc.user =:user and uc.status=1 and r.id IS NULL and c.enddate<:nowdate order by c.startdate DESC'
        );

        $query->setParameter('user', $user);
        $query->setParameter('nowdate', $dat);
        $entities = $query->getResult();
        return $entities;
    }

    public function findMyStudentToApprove($user) {

        $dat = date("Y-m-d");

        $query = $this->getEntityManager()
                ->createQuery(
                'SELECT u.id, u.name, u.lastName, u.photo, c.id as idc, c.title '
                . 'FROM AppBundle:Courses c '
                . 'LEFT JOIN  AppBundle:UserCourses uc WITH c.id=uc.course '
                . 'LEFT JOIN  AppBundle:User u  WITH u.id=uc.user  '
                . "LEFT JOIN  AppBundle:Reviews r WITH (c.id=r.evaluator and u.id=r.evaluated and r.type='estudiante')  "
                . 'WHERE c.user =:user and r.id IS NULL and c.enddate<:nowdate AND c.status=1 AND u.id IS NOT NULL order by c.startdate DESC '
        );

        /*
          SELECT  l1_.id AS id_4, l1_.title AS title_5, l0_.id AS id_0, l0_.name AS name_1, l0_.last_name AS last_name_2, l0_.photo AS photo_3, l3_.score, l3_.type_evaluated
          FROM lkw_courses l1_
          LEFT JOIN lkw_user_courses l2_ ON (l1_.id = l2_.course_id)
          LEFT JOIN lkw_user l0_ ON (l0_.id = l2_.user_id)
          LEFT JOIN lkw_reviews l3_ ON ((l1_.id = l3_.evaluator AND l0_.id = l3_.evaluated AND l3_.type_evaluated = 'estudiante'))
          WHERE l1_.user_id = 1 AND l1_.end_date < '2017-01-30' AND l3_.id IS NULL AND l1_.status=1 AND l0_.id IS NOT NULL   ORDER BY l1_.star_date DESC
         */

        $query->setParameter('user', $user);
        $query->setParameter('nowdate', $dat);
        $entities = $query->getResult();
        return $entities;
    }

}
