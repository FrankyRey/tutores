<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('bundles/FOSUserBundle/layout.html.twig');
    }

    /**
     * @Route("/registrate", name="signup")
     */
    public function singup()
    {
    	return $this->render('singup.html.twig');
    }

    /**
     * @Route("/solicitud", name="solicitud")
     */
    public function solicitud()
    {
        return $this->render('bundles/FOSUserBundle/solicitud.html.twig');
    }

    /**
     * @Route("/convocatoria", name="convocatoria")
     */
    public function convocatoria()
    {
        return $this->render('bundles/FOSUserBundle/solicitud.html.twig');
    }

    /**
     * @Route("/resutlados", name="resultados")
     */
    public function resultados()
    {
        return $this->render('bundles/FOSUserBundle/solicitud.html.twig');
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile()
    {
        return $this->render('bundles/FOSUserBundle/solicitud.html.twig');
    }
}
