<?php

namespace App\Controller;

use App\Entity\Material;
use App\Form\MaterialType;
use App\Repository\MaterialRepository;
use App\Services\MailerService;
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
        MailerService $mailerService,
        ): Response
    {

 // Initialisation des données de réponse pour la requête AJAX
        $resData = ['is_send_mess' => false];
        // Tester l'existance d'une requête AJAX
        if ($request->isXmlHttpRequest()) {
            // Récupérer tous les paramètres d'url ($_GET) de la requête AJAX
            $data = $request->query->all();
            $offset = intval($data['start']);
            $limit = intval($data['length']);
            $column = htmlentities($data['order'][0]['name']);
            $dir = htmlentities($data['order'][0]['dir']);
            $search = htmlentities($data['search']['value']);

            // Récupérer l'identifiant du matériau à modifier s'il existe
            $material_id = $request->query->get('material_id');

            // Tester l'existance d'une variable envoyé lors de la décrémentation et contenant l'identifiant (id)
            if($material_id) {
                $material = $materialRepository->find($material_id);
                $quantity = $material->getQuantity();

                if($quantity > 0) {
                    $new_Quantity = $material->getQuantity() - 1;
                    // Envoyer un email d'alerte si la quantité atteint 0
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
                            $resData['is_send_mess'] = true;
           
                    } 
                    // Mettre à jour la quantité du matériau en base de données
                    $material->setQuantity($material->getQuantity() - 1);
                    $em->flush();
                    
            }};

            // Récupérer les matériaux en fonction des critères de pagination et de recherche
            $materials = $materialRepository->findByCritaria(
                $offset,
                $limit,
                $column,
                $dir,
                $search
            );
            // Retourner les données au format JSON pour la requête AJAX
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
 // Afficher le template index.html.twig si ce n'est pas une requête AJAX
return $this->render('material/index.html.twig', []);
    }

    #[Route('/material/update/{id}', name: 'app_material_update')]
    public function update(
        int $id, 
        MaterialRepository $materialRepository, 
        Request $request,
        EntityManagerInterface $em){

        // Récupère le matériau à mettre à jour en fonction de l'identifiant passé en paramètre
        $material = $materialRepository->find($id);

        // Crée un formulaire en utilisant MaterialType 
        $form = $this->createForm(MaterialType::class, $material);

        // Associer les données de la requête au formulaire
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {

            // Persiste les modifications de l'objet Material en base de données
            $em->persist($material);
            $em->flush();
        

            // Redirige vers la page d'index 
            return $this->redirectToRoute('app_material_index');
        }

        // Affiche le formulaire dans le template update.html.twig s'il n'est pas encore soumis ou valide avec son identifiant et l'affichage du toast à l'écran
        return $this->render('material/update.html.twig', [
            'form' => $form->createView(), 
            'id' => $id,
        ]);
    }


    #[Route('/material/new', name: 'app_material_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        // Crée un nouvel objet Material
        $newMaterial = new Material();

         // Crée un formulaire en utilisant MaterialType 
        $form = $this->createForm(MaterialType::class, $newMaterial);

        // Associer les données de la requête au formulaire
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {

            // Persiste le nouvel objet Material en base de données
            $em->persist($newMaterial);
            $em->flush();

            // Redirige vers la page d'index
            return $this->redirectToRoute('app_material_index');
        }

        // Affiche le formulaire dans le template new.html.twig s'il n'est pas encore soumis ou valide
          return $this->render('material/new.html.twig', [
            'form' => $form->createView()
          ]);
    }

}