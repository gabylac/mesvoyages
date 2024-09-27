<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 * 
 */
class VisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visite::class);
    }

    //    /**
    //     * @return Visite[] Returns an array of Visite objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Visite
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    
    /**
     * retourne toutes les visites triées sur un champs
     * @param type $champs
     * @param type $ordre
     * @return visite[]
     */
    public function findAllOrderBy($champs, $ordre): array
    {
        return $this->createQueryBuilder('v')
                ->orderBy ('v.'.$champs, $ordre)
                ->getQuery()
                ->getResult();
    }
    
    /**
     * enregistrements dont un champs est égal à une valeur
     * ou tous les enregistrements si la valeur est vide 
     * @param type $champs
     * @param type $valeur
     * @return visite[]
     */
    public function findByEqualValue($champs, $valeur) :array{
        if($valeur == ""){
            return $this->createQueryBuilder('v')
                    ->orderBy('v.'.$champs, 'ASC')
                    ->getQuery()
                    ->getResult();
        }else{
            return $this->createQueryBuilder('v')
                    ->where('v.'.$champs.'= :valeur')
                    ->setParameter('valeur', $valeur)
                    ->orderBy('v.datecreation', 'DESC')
                    ->getQuery()
                    ->getResult();
        }
    }
    /**
     * supprime une visite
     * @param Visite $visite
     * @return void
     */
    public function remove(Visite $visite):void{
        $this->getEntityManager()->remove($visite);
        $this->getEntityManager()->flush();
    }
    /**
     * ajoute ou modifie une visite
     * @param Visite $visite
     * @return void
     */
    public function add(Visite $visite): void{
        $this->getEntityManager()->persist($visite);
        $this->getEntityManager()->flush();
    }
}
