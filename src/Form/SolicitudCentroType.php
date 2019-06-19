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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SolicitudCentroType extends AbstractType
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $curp = $options['curp'];
        $query = $this->em->createQuery('SELECT DISTINCT n.cct FROM App\Entity\Nomina n WHERE n.curp = :curp');
        $query->setParameter('curp', $curp);
        $centros = $query->getResult();

        foreach ($centros as $centro)
        {
            $choices [] = array('id' => $centro['cct'], 'label' => $centro['cct'],);
        }

        $builder->add('cct', ChoiceType::class, [
            'label' => 'Centro de Trabajo (CCT)',
            'placeholder' => '--Seleccione--',
            'choices' => array_column($choices, 'label', 'id'),
        ]);
        $builder->add('inicio', DateType::class, [
            'label' => 'Fecha de Ingreso',
            'years' => range(date('Y')-50, date('Y'))
        ]);
        $builder->add('nombreCct', TextType::class, [
            'label' => 'Nombre del CCT',
            'attr' => [
                'readonly' => true
            ]
        ]);
        $builder->add('telefonoCct', TextType::class, [
            'label' => 'Teléfono del CCT',
            'required' => false
        ]);
        $builder->add('zonaEscolar', TextType::class, [
            'label' => 'Zona Escolar',
            'required' => false,
            'attr' => [
                'readonly' => true
            ]
        ]);
        $builder->add('sectorEscolar', TextType::class, [
            'label' => 'Sector Escolar',
            'required' => false,
            'attr' => [
                'readonly' => true
            ]
        ]);
        $builder->add('asignatura', TextType::class, [
            'required' => false
        ]);
        $builder->add('taller', TextType::class, [
            'required' => false
        ]);
        $builder->add('idNivel', EntityType::class, [
            'label' => 'Nivel Educativo del CCT',
            'placeholder' => '--Seleccione--',
            'class' => NivelesEducativos::class,
            'choice_label' => 'nombreNivel'
        ]);
        $builder->add('aceptaTerminos', CheckboxType::class, [
            'required' => true,
            'label' => 'Acepto los <a>Terminos</a>'
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