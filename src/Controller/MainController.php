<?php

namespace App\Controller;

//Librerias Symfony
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

//Entidades
use App\Entity\NivelConvocatoria;
use App\Entity\SolicitudUsuario;
use App\Entity\SolicitudControl;
use App\Entity\SolicitudCentro;
use App\Entity\Municipios;
use App\Entity\EntidadesFederativas;
use App\Entity\Documentos;
use App\Entity\Nomina;
use App\Entity\CentrosDeTrabajo;
use App\Form\SolicitudUsuarioType;
use App\Form\SolicitudCentroType;
use App\Form\DocumentosType;

//Tipos de Entrada de datos

//PDF
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $nivel = $request->query->get('nivel');

        $solicitudUsuario->setNivelConvocatoria($request->query->get('nivel'));

        //$user = $this->getUser()->getId());
        $solicitudUsuario->setIdUser($this->getUser());

        $form = $this->createForm(SolicitudUsuarioType::class, $solicitudUsuario);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($solicitudUsuario);
            $entityManager->flush();

            return $this->redirect('/user/solicitud-centro?curp='.$curp.'&nivel='.$nivel);
        }

        return $this->render('bundles/FOSUserBundle/nueva-solicitud.html.twig', [
            'solicitud_usuario' => $solicitudUsuario,
            'form' => $form->createView(),
            'nivel' => $request->query->get('nivel')
        ]);
    }

    /**
     * @Route("/user/solicitud-centro", name="solicitud-centro")
     */
    public function solicitudCentro(Request $request)
    {
        $curp = $request->query->get('curp');
        $nivel = $request->query->get('nivel');

        $solicitudCentro = new SolicitudCentro();

        if($curp)
        {
            $solicitudCentro->setCurp($curp);
            $repository = $this->getDoctrine()->getRepository(SolicitudUsuario::class);
            $solicitudCentro->setIdSolicitud($repository->findOneBy([
                'curp' => $curp,
                'nivelConvocatoria' => $nivel
            ]));
        }
        $form = $this->createForm(SolicitudCentroType::class, $solicitudCentro, ['curp' => $curp]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $fecha = new DateTime();
            $solicitudCentro->setFechaAcepta(new \DateTime());
            $entityManager->persist($solicitudCentro);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('bundles/FOSUserBundle/solicitud-centro.html.twig', [
            'solicitud_centro' => $solicitudCentro,
            'form' => $form->createView(),
            'nivel' => $nivel,
        ]);
    }

    /**
     * @Route("/user/cambio-cct", name="cambio-cct")
     */
    public function cambioCct(Request $request)
    {
        $cct = $request->request->get('cct');
        $repository = $this->getDoctrine()->getRepository(CentrosDeTrabajo::class);

        $cctE = $repository->findOneBy([
            'cct' => $cct
        ]);

        if($cctE)
        {
            $responseArray = array(
                'nombre_cct' => $cctE->getNombreCct(),
                'zona' => $cctE->getZonaEscolar(),
                'sector' => $cctE->getSectorEscolar(),
            );
        }
        else
        {
            $responseArray = array();
        }

        return new JsonResponse($responseArray);
    }

    /**
     * @Route("/user/documentos", name="documentos")
     */
    public function documentos(Request $request)
    {
        $documento = new Documentos();
        $documento->setIdUser($this->getUser());

        $form = $this->createForm(DocumentosType::class, $documento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Recogemos el fichero
            $file=$form['nombreDocumento']->getData();
 
            // Sacamos la extensión del fichero
            $ext=$file->guessExtension();
 
            // Le ponemos un nombre al fichero
            $file_name=time().".".$ext;
 
            // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
            $file->move("prueba", $file_name);
 
            // Establecemos el nombre de fichero en el atributo de la entidad
            $documento->setNombreDocumento($file_name);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($documento);
            $entityManager->flush();

            return $this->redirectToRoute('documentos');
        }

        return $this->render('bundles/FOSUserBundle/documentos.html.twig', [
            'documento' => $documento,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/user/solicitud/personal/{idSolicitudUsuario}/edit", name="edit-solicitud-usuario", methods={"GET","POST"})
     */
    public function editarSolicitud(Request $request, SolicitudUsuario $solicitudUsuario)
    {
        $form = $this->createForm(SolicitudUsuarioType::class, $solicitudUsuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('bundles/FOSUserBundle/nueva-solicitud.html.twig', [
            'solicitud_usuario' => $solicitudUsuario,
            'form' => $form->createView(),
            'nivel' => $solicitudUsuario->getNivelConvocatoria(),
            'button_label' => 'Actualizar'
        ]);
    }

    /**
     * @Route("/user/solicitud/laboral/{idSolicitudUsuario}/edit", name="edit-solicitud-centro", methods={"GET","POST"})
     */
    public function editarSolicitudCentro(Request $request, SolicitudUsuario $solicitudUsuario)
    {
        $repository = $this->getDoctrine()->getRepository(SolicitudCentro::class);
        $SolicitudCentro = new SolicitudCentro();
        $solicitudCentro = $repository->findOneBy([
            'idSolicitud' => $solicitudUsuario->getIdSolicitudUsuario()
        ]);
        $form = $this->createForm(SolicitudCentroType::class, $solicitudCentro, ['curp' => $solicitudUsuario->getCurp()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('bundles/FOSUserBundle/solicitud-centro.html.twig', [
            'solicitud_centro' => $solicitudCentro,
            'form' => $form->createView(),
            'nivel' => $solicitudUsuario->getNivelConvocatoria(),
            'button_label' => 'Actualizar'
        ]);
    }

    /**
     * @Route("/user/ficha/{idSolicitudUsuario}", name="ficha", methods={"GET","POST"})
     */
    public function imprimirFicha(Request $request, SolicitudUsuario $solicitudUsuario)
    {
        $repository = $this->getDoctrine()->getRepository(SolicitudCentro::class);
        $repositoryP = $this->getDoctrine()->getRepository(Nomina::class);
        $SolicitudCentro = new SolicitudCentro();
        $solicitudCentro = $repository->findOneBy([
            'idSolicitud' => $solicitudUsuario->getIdSolicitudUsuario()
        ]);
        $plazas = $repositoryP->findBy([
            'cct' => $solicitudCentro->getCct(),
            'curp' => $solicitudUsuario->getCurp(),
        ]);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
        // Retrieve the HTML generated in our twig file
        $html2 = $this->renderView('default/mypdf.html.twig', [
            'solicitud_usuario' => $solicitudUsuario,
            'solicitud_centro' => $solicitudCentro,
            'plazas' => $plazas,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html2);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
}
