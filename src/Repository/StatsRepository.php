<?php


namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class StatsRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Product::class);
    }


    /**
     * Une fonction utilitaire qui converti les centimes passés en paramètres en un tableau sous forme [euros, centimes].
     * @author Mael
     * @param mixed $cent un nombre de centimes à cenvertir en euros
     * @return int[] un tableau content les euros et les centimes obtenus de la conversion des centimes en euros
     */
    public function toEuros($cent): array {
        $fnCent = $cent % 100;
        $fnEuros = $cent / 100;

        return [$fnEuros, $fnCent];
    }



    /**
     * Retourne le total dépensé 
     * @return JsonResponse
     */

    /*
    public function getTotalSpent(): JsonResponse {

        /* l'ORM force l'exécution non manuelle de SQL, aucune documentation sur comment faire sans.
        $query = "SELECT SUM(euros) AS EUR, SUM(centimes) AS CENT FROM listed_product WHERE bought = true";

        $results = $this->executeQuery($query);

        $row = $results->fetchAssociative();

        return new JsonResponse(["EUR" => $row['EUR'], 'CENT' => $row['CENT']]);


        $queryBuilder = $this->createQueryBuilder('Product');
        
        $queryBuilder
            ->select('SUM(Product.euros) AS EUR, SUM(Product.centimes) AS CENT')
            ->from('Product')
            ->join('');
        
    
    }
*/

    public function getAvgProductCost() {
        $query = "SELECT AVG(euros) AS EUR, SUM(centimes) AS CENT FROM Product";

        $results = $this->executeQuery($query);

        $row = $results->fetchAssociative();

        $eurcents = $this->toEuros($row['CENT']);
        $eur = $row['EUR'] + $eurcents[0];
        $cent = $row['CENT'] + $eurcents[1]; 

        return new JsonResponse(['EUR' => $eur, 'CENT' => $cent]);
    }
}