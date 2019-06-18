<?php
namespace App\Form;

use App\Entity\SolicitudUsuario;
use App\Entity\EntidadesFederativas;
use App\Entity\Municipios;
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

class SolicitudUsuarioType extends AbstractType
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('apellidoPaterno', TextType::class, [
            'label' => 'Apellido Paterno'
        ]);
        $builder->add('apellidoMaterno', TextType::class, [
            'required' => false,
            'label' => 'Apellido Materno'
        ]);
        $builder->add('nombre', TextType::class);
        $builder->add('telefonoFijo', TextType::class, [
            'label' => 'Telefono Fijo',
            'required' => false
        ]);
        $builder->add('telefonoCelular', TextType::class, [
            'label' => 'Telefono Celular'
        ]);
        $builder->add('rfc', TextType::class, [
            'label' => 'RFC',
            'attr' => [
                'maxlength' => 13
            ]
        ]);
        $builder->add('curp', TextType::class, [
            'label' => 'CURP',
            'attr' => [
                'readonly' => true
            ]
        ]);
        $builder->add('calle', TextType::class);
        $builder->add('noExterior', TextType::class, [
            'label' => 'No. Exterior',
            'required' => false
        ]);
        $builder->add('noInterior', TextType::class, [
            'label' => 'No. Interior',
            'required' => false
        ]);
        $builder->add('codigoPostal', TextType::class, [
            'label' => 'Codigo Postal',
            'attr' => [
                'maxlength' => 5
            ]
        ]);
        $builder->add('colonia', TextType::class);
        $builder->add('idEntidadFederativa', EntityType::class, [
            'label' => 'Entidad Federativa',
            'placeholder' => '--Seleccione--',
            'class' => EntidadesFederativas::class,
            'choice_label' => 'nombreEntidadFederativa'
        ]);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        //$builder->get('idEntidadFederativa')->addEventListener(FormEvents::POST_SUBMIT, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
    }

    protected function addElements(FormInterface $form, EntidadesFederativas $entidad = null) {
        // 4. Add the province element
        
        // Neighborhoods empty, unless there is a selected City (Edit View)
        
        // If there is a city stored in the Person entity, load the neighborhoods of it
        if ($entidad) {
            // Fetch Neighborhoods of the City if there's a selected city
            $repoMunicipios = $this->em->getRepository(Municipios::class);
            
            $municipios = $repoMunicipios->findBy(
                ['idEntidadFederativa' => $entidad->getIdEntidadFederativa()]
            );

            // Add the Neighborhoods field with the properly data
            $form->add('idMunicipioEntidadFederativa', EntityType::class, [
                'label' => 'Municipio',
                'required' => true,
                'placeholder' => '--Seleccione--',
                'class' => Municipios::class,
                'choices' => $municipios
            ]);
        }
    }
    
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        $municipio = new Municipios();
        $entidad = new EntidadesFederativas();
        
        print_r(var_dump($data['idEntidadFederativa']));
        // Search for selected City and convert it into an Entity
        $idEntidad = $data['idEntidadFederativa'];
        $idMunicipio = $data['idMunicipioEntidadFederativa'];

        $entidad = $this->em->getRepository(EntidadesFederativas::class)->findOneBy([
            'idEntidadFederativa' => (int)$idEntidad
        ]);

        $municipio = $this->em->getRepository(Municipios::class)->findOneBy([
            'idEntidadFederativa' => (int)$idEntidad,
            'idMunicipios' => (int)$idMunicipio
        ]);
        
        $this->addElements($form, $entidad);
    }

    function onPreSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        $municipio = new Municipios();
        $entidad = new EntidadesFederativas();

        // When you create a new person, the City is always empty
        $entidad = $data->getIdEntidadFederativa();
        
        $municipios = [];

        if($entidad)
        {
            $repoMunicipios = $this->em->getRepository(Municipios::class);
                    
            $municipios = $repoMunicipios->findBy(
                ['idEntidadFederativa' => $entidad->getIdEntidadFederativa()]
            );
        }

        $form->add('idMunicipioEntidadFederativa', EntityType::class, [
            'label' => 'Municipio',
            'required' => true,
            'placeholder' => '--Seleccione--',
            'class' => Municipios::class,
            'choices' => $municipios
        ]);

        $this->addElements($form, $entidad);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SolicitudUsuario::class,
        ]);
    }
}