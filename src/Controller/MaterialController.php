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

        $resData = ['is_send_mess' => false];
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
                $quantity = $material->getQuantity();
                if($quantity > 0) {
                    $new_Quantity = $material->getQuantity() - 1;
                    
                    if($new_Quantity === 0) {
                        $mailerService->sendEmail(
                            subject : "Message d'alerte",
                            from : "material_plugin@exemple.fr",
                            to : "administrateur@exemple.fr",
                            template: "email/email_alert.html.twig", 
                            data: [
                                "material_name"=> $material->getName()
                            ],
                           
                            );
                            //$messageService->addSuccess("Un email a été envoyé à l'administrateur");
           
                    } else {
                        $resData['is_send_mess'] = true;
                    }
                    $material->setQuantity($material->getQuantity() - 1);
                    $em->flush();
                    
                  
            

           
            }};

            $materials = $materialRepository->findByCritaria(
                $offset,
                $limit,
                $column,
                $dir,
                $search
            );

            return $this->json(
                array_merge($resData,
                [
                    'data' => $materials,
                    'draw' => intval($data['draw']),
                    "recordsTotal" => $materialRepository->getTotalRecords(),
                    "recordsFiltered" => $search ? $materialRepository->countByFilteredRecords($search) : $materialRepository->getTotalRecords()
                ]),
                headers: ['Content-Type' => 'application/json;charset=UTF-8']
            );
        }

return $this->render('material/index.html.twig', []);
    }

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
}