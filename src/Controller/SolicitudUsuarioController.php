<?php

namespace App\Controller;

use App\Entity\SolicitudUsuario;
use App\Form\SolicitudUsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/solicitud/usuario")
 */
class SolicitudUsuarioController extends AbstractController
{
    /**
     * @Route("/", name="solicitud_usuario_index", methods={"GET"})
     */
    public function index(): Response
    {
        $solicitudUsuarios = $this->getDoctrine()
            ->getRepository(SolicitudUsuario::class)
            ->findAll();

        return $this->render('solicitud_usuario/index.html.twig', [
            'solicitud_usuarios' => $solicitudUsuarios,
        ]);
    }

    /**
     * @Route("/new", name="solicitud_usuario_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $solicitudUsuario = new SolicitudUsuario();
        $form = $this->createForm(SolicitudUsuarioType::class, $solicitudUsuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($solicitudUsuario);
            $entityManager->flush();

            return $this->redirectToRoute('solicitud_usuario_index');
        }

        return $this->render('solicitud_usuario/new.html.twig', [
            'solicitud_usuario' => $solicitudUsuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSolicitudUsuario}", name="solicitud_usuario_show", methods={"GET"})
     */
    public function show(SolicitudUsuario $solicitudUsuario): Response
    {
        return $this->render('solicitud_usuario/show.html.twig', [
            'solicitud_usuario' => $solicitudUsuario,
        ]);
    }

    /**
     * @Route("/{idSolicitudUsuario}/edit", name="solicitud_usuario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SolicitudUsuario $solicitudUsuario): Response
    {
        $form = $this->createForm(SolicitudUsuarioType::class, $solicitudUsuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('solicitud_usuario_index', [
                'idSolicitudUsuario' => $solicitudUsuario->getIdSolicitudUsuario(),
            ]);
        }

        return $this->render('solicitud_usuario/edit.html.twig', [
            'solicitud_usuario' => $solicitudUsuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idSolicitudUsuario}", name="solicitud_usuario_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SolicitudUsuario $solicitudUsuario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$solicitudUsuario->getIdSolicitudUsuario(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($solicitudUsuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('solicitud_usuario_index');
    }
}
