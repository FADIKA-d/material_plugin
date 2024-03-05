<?php

namespace App\Controller;

use App\Entity\Material;
use App\Form\MaterialType;
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


    #[Route('/form', name: 'app_form_index')]
    public function new(Request $request, MaterialRepository $materialRepository): Response
    {
        // creates a task object and initializes some data for this example
        $newMaterial = new Material();
        // $newMaterial->setName($request->get('new name'));
        // $newMaterial->setQuantity($request->get('5'));
        // $newMaterial->setPriceBeforeTax($request->get('3'));
        // $newMaterial->setPriceIncVAT($request->get('4'));
        // $newMaterial->setVAT($request->get('5'));
        // $newMaterial->setCreatedAt($request->get(date_create_immutable()));

        $form = $this->createForm(MaterialType::class, $newMaterial);
        $form->handleRequest($request);
          return $this->render('form/form.html.twig', [
            'form' => $form,
          ]);
    }


    // #[Route('/material', name: 'app_material_index')]
    // public function updateOneMaterial(MaterialRepository $materialRepository, Request $request, int $id): Response
    // {
    //     // $materialToUpdate = new Material();
        

    //     $materialToUpdate = $materialRepository->getRepository(MaterialController::class)->find($id);
    //     if (!$materialToUpdate) {
    //         throw $this->createNotFoundException('No product found for id' .$id);
    //     }

    //     $materialToUpdate->setName($request->get('new name'));
    //     $materialToUpdate->setQuantity($request->get('5'));
    //     $materialToUpdate->setPriceBeforeTax($request->get('3'));
    //     $materialToUpdate->setPriceIncVAT($request->get('4'));
    //     $materialToUpdate->setVAT($request->get('5'));
    //     $materialRepository->setCreatedAt($request->get(date('Y-m-d')));

    //     // $materialRepository->persist($materialToUpdate);
    //     $materialRepository->flush();

    //     return new Response('Save new product',200);
    //     // return $this->redirectToRoute('app_material_index');
    // }
}
