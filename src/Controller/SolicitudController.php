<?php

namespace App\Controller;

use App\Entity\SolicitudUsuario;
use App\Entity\Municipios;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

// Include JSON Response
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * SolicitudUsuario controller.
 *
 */
class SolicitudController extends Controller
{
    // Rest of your original controller


    /**
     * Returns a JSON string with the neighborhoods of the City with the providen id.
     * 
     * @param Request $request
     * @return JsonResponse
     * @Route("/user/get-municipios", name="get-municipios")
     */
    public function listMunicipios(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Municipios::class);
        $entidad = $request->request->get('cityid');
        $resultados = $repository->findBy(['idEntidadFederativa' => $entidad]);

        if($resultados)
        {
            $responseArray = array();
            foreach ($resultados as $valor)
            {
                $responseArray [] = array(
                    'id' => $valor->getIdMunicipios(),
                    'nombre' => $valor->getNombreMunicipios()
                );
            }
        }

        return new JsonResponse($responseArray);
    }
}
