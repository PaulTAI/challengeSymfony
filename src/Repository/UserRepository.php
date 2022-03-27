<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(User $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(User $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * delete an user
     * 
     * @param integer $id user id
     */
    public function deleteUser(int $id)
    {
        $em = $this->getEntityManager();
        $user = $this->findBy(["id" => $id])[0];
        $em->remove($user);
        $em->flush();
    }

    /**
     * Get the user role by his id
     *
     * @param integer $id
     * @return void
     */
    public function getUserRolesById(int $id)
    {
        return (array)$this->findBy(['id' => $id])[0]->getRoles();
    }

    public function setRole($role, $id)
    {
        $em = $this->getEntityManager();
        $user = $this->findBy(["id" => $id])[0];
        $user->setRoles($role);
        $em->persist($user);
        $em->flush();
    }

    public function getUserName($id)
    {
        $userFirstname = $this->findBy(['id' => $id])[0]->getFirstname();
        $userLastname = $this->findBy(['id' => $id])[0]->getLastname();

        return array($userFirstname, $userLastname);
    }

    /**
     * Return les users qui ne sont pas validés (false)
     */
    public function getUserNotValidate(){
        return (array)$this->findBy(['isValidate' => false]);
    }
}
