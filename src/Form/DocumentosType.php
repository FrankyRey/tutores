<?php
namespace App\Form;

use App\Entity\Documentos;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DocumentosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombreDocumento', FileType::class, [
            'label' => 'Seleccione Documento'
        ]);
        $builder->add('referencia', ChoiceType::class, [
            'label' => 'Tipo de Documento',
            'placeholder' => '--Seleccione--',
            'choices' => [
                'Título' => 'Título',
                'Curso' => 'Curso',
                'Reconocimiento' => 'Reconocimiento',
                'Publicación' => 'Publicación'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Documentos::class,
        ]);
    }
}