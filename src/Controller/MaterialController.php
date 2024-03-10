<?php

namespace App\Controller;

use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MaterialController extends AbstractController
{
    
    
    #[Route('/material', name: 'app_material_index')]
    public function index( EntityManagerInterface $em,
        MaterialRepository $materialRepository, 
        Request $request,
        ): Response
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

            $material_id = $request->query->get('material_id');

            if($material_id) {
                $material = $materialRepository->find($material_id);
                if($material->getQuantity() > 0) {
                    $material->setQuantity($material->getQuantity() - 1);
                    $em->flush();
                }
            };

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

    // #[Route('/material', name: 'app_material_show')]
    // public function show(MaterialRepository $materialRepository): Response
    // {
    //     $materials = $materialRepository;
    //     return $this->render('/material/index.html.twig', [
    //         'materials'=> $materials]);

    // }
    #[Route('/material/update/{id}', name: 'app_material_show')]
    public function show(
        int $id, 
        MaterialRepository $materialRepository, 
        Request $request,
        EntityManagerInterface $em){

        $material = $materialRepository->find($id);
        $form = $this->createForm(MaterialType::class, $material);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($material);
            $em->flush();
            return $this->redirectToRoute('app_material_index');
        }
        return $this->render('material/update.html.twig', [
            'form' => $form]);
    }


    #[Route('/material/new', name: 'app_material_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        // creates a task object and initializes some data for this example
        $newMaterial = new Material();

        $form = $this->createForm(MaterialType::class, $newMaterial);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newMaterial);
            $em->flush();
            return $this->redirectToRoute('app_material_index');
        }
          return $this->render('material/new.html.twig', [
            'form' => $form->createView()
          ]);
    }
    // #[Route('/material/decrement/{id}', name: 'app_material_decrement')]
    // public function decrementQ(int $id, 
    // MaterialRepository $materialRepository, 
    // Request $request,
    // EntityManagerInterface $em): Response {
    //     $material = $materialRepository->find($id);
    //     $quantity = $material->getQuantity();
    //     if( $quantity > 1) {
    //         $newQuantity = $quantity - 1;
    //         $material->setQuantity($newQuantity);
    //         $em->persist($material);
    //         $em->flush();
    //     };
    //     return $this->render('material/index.html.twig', [
    //         'id' => $material->getId()
    //     ]);
    // }


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
