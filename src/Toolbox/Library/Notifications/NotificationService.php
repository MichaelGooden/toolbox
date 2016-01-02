<?php
namespace Toolbox\Library\Notifications;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

//Zend Paging
use Toolbox\Entity\Notifications;
use Zend\Paginator\Paginator;

//Doctrine Paging
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class NotificationService
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     * @access protected
     */
    protected $objectManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $objectRepository;

    /**
     * @param ObjectManager $objectManager
     * @param ObjectRepository $notificationsRepository
     */
    public function __construct(
        ObjectManager $objectManager,
        ObjectRepository $notificationsRepository
    ) {
        $this->objectManager = $objectManager;
        $this->notificationsRepository = $notificationsRepository;
    }

    /**
     * @param $id
     * @return bool|object
     */
    public function find($id)
    {
        $settingsObject = $this->notificationsRepository->find($id);

        if (!$settingsObject instanceof Notifications) {
            return null;
        }

        return $settingsObject;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->notificationsRepository->findAll();
    }


    /**
     * This function returns notification information for the last n hours
     * @param $hours
     * @return mixed
     */
    public function getLastHours($hours)
    {
        $date = new \DateTime();
        $date->sub( new \DateInterval("PT".$hours."H") );

        $fromDate = $date->format('Y-m-d h:m:s');

        $result = $this->notificationsRepository->createQueryBuilder('u')
            ->select('u.id,u.type,u.message')
            ->where('u.created >= :from')
            ->setParameter('from',$fromDate)
            ->getQuery()
            ->execute();

        return $result;
    }

    /**
     * This returns notifications for a given date range and a given notification type
     * @param $hours
     * @param $type_id
     * @return mixed
     */
    public function getNotificationCount( $hours = null, $type_id = null )
    {

        //Return global notification count
        if ( null === $hours AND null === $type_id )
        {

            return $this->notificationsRepository->createQueryBuilder('u')
                ->select('count(u.id)')
                ->getQuery()
                ->getSingleScalarResult();

        }

        //Return all notification for a specified time frame
        if ( null !== $hours AND null === $type_id )
        {
            $date = new \DateTime();
            $date->sub( new \DateInterval("PT".$hours."H") );
            $fromDate = $date->format('Y-m-d h:m:s');

            return $this->notificationsRepository->createQueryBuilder('u')
                ->select('count(u.id)')
                ->where('u.created >= :from')
                ->setParameter('from' , $fromDate)
                ->getQuery()
                ->getSingleScalarResult();

        }

        //Return total notification count for a specified type_id
        if ( null === $hours AND null !== $type_id )
        {
            return $this->notificationsRepository->createQueryBuilder('u')
                ->select('count(u.id)')
                ->where('u.type = :type_id')
                ->setParameter('type_id' , $type_id)
                ->getQuery()
                ->getSingleScalarResult();
        }

        //Return specific hours for a specific type_id
        if ( null !== $hours AND null !== $type_id)
        {
            $date = new \DateTime();
            $date->sub( new \DateInterval("PT".$hours."H") );
            $fromDate = $date->format('Y-m-d h:m:s');

            return $this->notificationsRepository->createQueryBuilder('u')
                ->select('count(u.id)')
                ->where('u.type = :type_id')
                ->andWhere('u.created >= :from')
                ->setParameter('from' , $fromDate)
                ->setParameter('type_id' , $type_id)
                ->getQuery()
                ->getSingleScalarResult();
        }


    }

    /**
     * @param $page
     * @param $count
     * @param $type_id
     * @return Paginator
     */
    public function getPaged( $page, $count , $type_id = 0 )
    {
        if ( 0 === $type_id)
        {
            $qb   = $this->notificationsRepository->createQueryBuilder('u');
            $qb->add('orderBy', 'u.created DESC');

        }  else {
            $qb   = $this->notificationsRepository->createQueryBuilder('u')
                ->where('u.type = :type_id')
                ->setParameter('type_id' , $type_id);

            $qb->add('orderBy', 'u.created DESC');
        }

        $adapter   = new DoctrineAdapter( new ORMPaginator( $qb ) );
        $paginator = new Paginator($adapter);

        return $paginator->setCurrentPageNumber( (int) $page )->setItemCountPerPage( (int) $count );

    }

    /**
     * @param Notifications $notificationObject
     * @return Notifications|bool
     */
    public function update( Notifications $notificationObject )
    {
        try {
            $this->objectManager->persist($notificationObject);
            $this->objectManager->flush();
        } catch (\Exception $e) {
            return false;
        }

        return $notificationObject;
    }


}