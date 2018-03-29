<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imagePath', FileType::class, array(
                'label' => 'Sélectionner une image',
                'invalid_message' => 'Veuillez sélectionner un fichier valide.',
                'data_class' => null,
                'required' => false
            ))
            ->add('content', TextareaType::class, array(
                'label' => "Contenu de l'article",
                'invalid_message' => 'Veuillez saisir un contenu valide.',
                'attr' => array('class' => 'tinymce')
            ))
            ->add('save', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'add_post';
    }
}
