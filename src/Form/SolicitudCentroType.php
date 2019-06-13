<?php
namespace App\Form;

use App\Entity\SolicitudCentro;
use App\Entity\SolicitudUsuario;
use App\Entity\NivelesEducativos;
use App\Entity\Nomina;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SolicitudCentroType extends AbstractType
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $curp = $options['curp'];
        $repo = $this->em->getRepository(Nomina::class);

        $centros = $repo->findBy([
            'curp' => $curp
        ]);

        $builder->add('cct', ChoiceType::class, [
            'choices' => $centros,
            'choice_label' => 'cct',
            'choice_value' => 'cct'
        ]);
        $builder->add('inicio', TextType::class);
        $builder->add('nombreCct', TextType::class);
        $builder->add('telefonoCct', TextType::class);
        $builder->add('zonaEscolar', TextType::class);
        $builder->add('sectorEscolar', TextType::class);
        $builder->add('asignatura', TextType::class);
        $builder->add('taller', TextType::class);
        $builder->add('idNivel', EntityType::class, [
            'placeholder' => 'Select a City...',
            'class' => NivelesEducativos::class,
            'choice_label' => 'nombreNivel'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SolicitudCentro::class,
            'curp' => '',
        ]);

        $resolver->setRequired('curp'); // Requires that currentOrg be set by the caller.
        $resolver->setAllowedTypes('curp', 'string'); // Validates the type(s)
    }
}