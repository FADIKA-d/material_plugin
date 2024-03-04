<?php

namespace App\Controller;

use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaterialController extends AbstractController
{
    #[Route('/material', name: 'app_material_index')]
    public function index(MaterialRepository $materialRepository, Request $request): Response
    {
        // Tester l'existance d'une requête AJAX
        if ($request->isXmlHttpRequest()) {
            // On récupère tous les paramètres d'url ($_GET)
            $data = $request->query->all();
            $offset = intval($data['start']);
            $limit = intval($data['length']);
            $column = htmlentities($data['order'][0]['name']);
            $dir = htmlentities($data['order'][0]['dir']);
            $search = htmlentities($data['search']['value']);

            $materials = $materialRepository->findByCritaria(
                $offset,
                $limit,
                $column,
                $dir,
                $search
            );

            return $this->json(
                [
                    'data' => $materials,
                    'draw' => intval($data['draw']),
                    "recordsTotal" => $materialRepository->getTotalRecords(),
                    "recordsFiltered" => $search ? $materialRepository->countByFilteredRecords($search) : $materialRepository->getTotalRecords()
                ],
                headers: ['Content-Type' => 'application/json;charset=UTF-8']
            );
        }

        return $this->render('material/index.html.twig', []);
    }
}
