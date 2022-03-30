<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return parent::findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findById(Uuid $uuid)
    {
        return $this->findBy(
            [
                'id' => $uuid,
            ],
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getSessionsInfo(): array
    {
        $sessionsInfo = [];

        $sessions = $this->findAll();

        foreach ($sessions as $session) {
            $key = $session->getId()->toRfc4122();
            $value = $session->getFilmName() . ' Начало фильма: ' . gmdate('Y-m-d H:i:s', $session->getStartTime()->getTimeStamp());

            $sessionsInfo[$key] = $value;
        }

        return array_flip($sessionsInfo);
    }
}
