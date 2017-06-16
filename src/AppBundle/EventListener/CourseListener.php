<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Entity\User;
use AppBundle\Entity\Courses;
use AppBundle\Entity\Reviews;

class CourseListener {

    private $total;

    public function __construct() {
        $this->total = 0;
    }

    public function postLoad(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        if ($entity instanceof Courses) :
            $em = $args->getEntityManager();
            $query = $em
                    ->createQuery(
                    'SELECT avg(r.score) as score_avg '
                    . 'FROM AppBundle:Courses c '
                    . "LEFT JOIN  AppBundle:Reviews r WITH (c.id=r.evaluated )  "
                    . "WHERE r.type='curso' and c.id=:course"
            );

            $query->setParameter('course', $entity->getId());
            $tot = $query->getResult();
            $entity->setReview(($tot[0]["score_avg"]===null)?(int)0:(int)$tot[0]["score_avg"]);
            
        endif;
    }

}
