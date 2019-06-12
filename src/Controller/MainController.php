<?php

namespace App\Controller;

//Librerias Symfony
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

//Entidades
use App\Entity\NivelConvocatoria;
use App\Entity\SolicitudUsuario;
use App\Entity\Municipios;
use App\Entity\EntidadesFederativas;
use App\Entity\FosUser;
use App\Form\SolicitudUsuarioType;

//Tipos de Entrada de datos


class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $user = $this->getUser();
        $repository = $this->getDoctrine()->getRepository(SolicitudUsuario::class);
        $solicitudes = $repository->findBy([
            'idUser' => $user->getId()
        ]);
        return $this->render('bundles/FOSUserBundle/layout.html.twig', [
            'solicitudes' => $solicitudes
        ]);
    }

    /**
     * @Route("/user/solicitud", name="solicitud")
     */
    public function solicitud()
    {
        return $this->render('bundles/FOSUserBundle/solicitud.html.twig');
    }

    /**
     * @Route("/user/convocatoria", name="convocatoria")
     */
    public function convocatoria()
    {
        return $this->render('bundles/FOSUserBundle/solicitud.html.twig');
    }

    /**
     * @Route("/user/resutlados", name="resultados")
     */
    public function resultados()
    {
        return $this->render('bundles/FOSUserBundle/solicitud.html.twig');
    }

    /**
     * @Route("/user/profile", name="profile")
     */
    public function profile()
    {
        return $this->render('bundles/FOSUserBundle/solicitud.html.twig');
    }

    /**
     * @Route("/admin/expedientes", name="expedientes")
     */
    public function expedientes()
    {
        return $this->render('bundles/FOSUserBundle/solicitud.html.twig');
    }

    /**
     * @Route("/ajax_request", name="validaCurp")
     */
    public function validaCurp(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(NivelConvocatoria::class);
        $curp = $request->request->get('curp');
        $resultados = $repository->findBy(['curp' => $curp]);

        if($resultados)
        {
            $output = '<p>Por favor seleccione en que nivel desea impartir la tutoria.</p><div class="form-group"><select class="form-control"><option>--Seleccione una opción--</option>';
            foreach ($resultados as $valor)
            {
                $output = $output.'<option value="'.$valor->getNivelConvocatoria().'">'.$valor->getNivelConvocatoria().'</option>';
            }
            $output = $output.'</select></div><div class="solicitud"></div>';
            $encontrado = 1;
        }
        else
        {
            $output = '<p class=text-danger>El curp proporcionado no se encuentra registrado como trabajador de sep, verifique la información</p>';
            $encontrado = 0;
        }

        $arrData = ['output' => $output,
                    'encontrado' => $encontrado];
        return new JsonResponse($arrData);
    }

    /**
     * @Route("/user/nueva-solicitud", name="nueva-solicitud")
     */
    public function nuevaSolicitud(Request $request)
    {
        $solicitudUsuario = new SolicitudUsuario();
        $user = new FosUser();

        $curp = $request->query->get('curp');
        $solicitudUsuario->setCurp($curp);

        $solicitudUsuario->setNivelConvocatoria($request->query->get('nivel'));

        $user = $this->getDoctrine()->getRepository(FosUser::class)->findOneById($this->getUser()->getId());
        $solicitudUsuario->setIdUser($user);

        $form = $this->createForm(SolicitudUsuarioType::class, $solicitudUsuario);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($solicitudUsuario);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('bundles/FOSUserBundle/nueva-solicitud.html.twig', [
            'solicitud_usuario' => $solicitudUsuario,
            'form' => $form->createView()
        ]);
    }
}
