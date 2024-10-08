<?php


namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    
    #[Route('/voyages/recherche/{champs}', name: 'voyages.findallequal')]
    public function findAllEqual($champs, Request $request):Response{
        if($this->isCsrfTokenValid('filtre_'.$champs, $request->get('_token'))){
            $valeur = $request->get("recherche");
            $visites = $this->repository->findByEqualValue($champs, $valeur);
            return $this->render("pages/voyages.html.twig", ['visites' => $visites]);
        }
        return $this->redirectToRoute("voyages");
    }
    /**
     * @Route("/voyages/voyage/{id}", name= "voyages.showone")
     * @param type $id
     * @return Response
     */
    #[Route('/voyages/voyage/{id}', name: 'voyages.showone')]
    public function showOne($id) : Response{
        $visite = $this->repository ->find($id);
        return $this->render("pages/voyage.html.twig", ['visite' => $visite]);
    }

}


