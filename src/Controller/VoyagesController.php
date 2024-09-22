<?php


namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of VoyagesController
 *
 * @author Moi
 */
class VoyagesController extends AbstractController{
    #[Route('/voyages', name: 'voyages')]
    public function index() : Response {
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render("pages/voyages.html.twig", ['visites'=> $visites]);
    }
    
    /**
     * 
     * @var VisiteRepository
     */
    private $repository;
    /**
     * 
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository) {
        $this->repository = $repository;
    }
    #[Route('/voyages/tri/{champs}/{ordre}', name: 'voyages.sort')]
    public function sort($champs, $ordre): Response{
        $visites = $this->repository->findAllOrderBy($champs, $ordre);
        return $this->render("pages/voyages.html.twig", ['visites' => $visites]);
    }

}


