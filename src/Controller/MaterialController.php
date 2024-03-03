<?php

namespace App\Controller;

use App\Repository\MaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class MaterialController extends AbstractController
{
    #[Route('/material', name: 'app_material_index')]
    public function index(MaterialRepository $materialRepository, Request $request): Response
    {
        $materials = $materialRepository->findAll();
        // Tester l'existance d'une requête AJAX
        if ($request->isXmlHttpRequest()) {


            // Pb rencontré lors de la transformation de mon tableau d'objets en json : A circular reference has been detected when serializing the object of class "App\Entity\Material" (configured limit: 1)
            // Le pb serait du à la présence de la relation 1:n avec l'entité VAT.

            // solution trouvée sur internet https://stackoverflow.com/questions/59268438/a-circular-reference-has-been-detected-when-serializing-the-object-of-class-app
            $defaultContext = [
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                    return $object->getId();
                },
            ];


            return $this->json(['data' => $materials], headers: ['Content-Type' => 'application/json;charset=UTF-8'], context: $defaultContext);
        }

        return $this->render('material/index.html.twig', [
            'materials' => $materials,
        ]);
    }
}
