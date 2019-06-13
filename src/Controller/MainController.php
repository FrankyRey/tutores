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
use App\Entity\SolicitudControl;
use App\Entity\SolicitudCentro;
use App\Entity\Municipios;
use App\Entity\EntidadesFederativas;
use App\Form\SolicitudUsuarioType;
use App\Form\SolicitudCentroType;

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
        if($user)
        {
            $solicitudes = $repository->findBy([
                'idUser' => $user->getId()
            ]);
            return $this->render('bundles/FOSUserBundle/layout.html.twig', [
                'solicitudes' => $solicitudes
            ]);
        }
        else
        {
            return $this->redirect('/login');
        }
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
        $resultados = $repository->findBy(['curp' => $curp],['nivelConvocatoria' => 'ASC']);

        if($resultados)
        {
            $contadorB = 0;
            $solicitudRepository = $this->getDoctrine()->getRepository(SolicitudUsuario::class);
            $output = '<p>Por favor seleccione en que nivel desea impartir la tutoria.</p><div class="form-group"><select class="form-control" id="nivel-convocatoria"><option>--Seleccione una opción--</option>';
            foreach ($resultados as $valor)
            {
                $solicitud = $solicitudRepository->findOneBy(['nivelConvocatoria' => $valor->getNivelConvocatoria()]);
                if(!$solicitud)
                {
                    $output = $output.'<option value="'.$valor->getNivelConvocatoria().'">'.$valor->getNivelConvocatoria().'</option>';
                }
                else
                {
                    $contadorB = $contadorB+1;
                    $encontrado = 1;
                }
            }
            if(count($resultados)==$contadorB)
            {
                $output = '<p class="text-danger">Usted ya cuenta con el máximo de solicitudes permitidas</p>';
            }
            else
            {
                $output = $output.'</select></div><div class="solicitud"></div>';
                $encontrado = 1;
            }
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

        $curp = $request->query->get('curp');
        if(!$curp)
        {
            return $this->redirectToRoute('solicitud');
        }
        $solicitudUsuario->setCurp($curp);

        $solicitudUsuario->setNivelConvocatoria($request->query->get('nivel'));

        //$user = $this->getUser()->getId());
        $solicitudUsuario->setIdUser($this->getUser());

        $form = $this->createForm(SolicitudUsuarioType::class, $solicitudUsuario);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($solicitudUsuario);
            $entityManager->flush();

            return $this->redirect('/user/solicitud-centro?curp='.$curp);
        }

        return $this->render('bundles/FOSUserBundle/nueva-solicitud.html.twig', [
            'solicitud_usuario' => $solicitudUsuario,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/solicitud-centro", name="solicitud-centro")
     */
    public function solicitudCentro(Request $request)
    {
        $curp = $request->query->get('curp');

        $solicitudCentro = new SolicitudCentro();
        $form = $this->createForm(SolicitudCentroType::class, $solicitudCentro, ['curp' => $curp]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($solicitudCentro);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('bundles/FOSUserBundle/solicitud-centro.html.twig', [
            'colicitud_centro' => $solicitudCentro,
            'form' => $form->createView(),
        ]);
    }
}
