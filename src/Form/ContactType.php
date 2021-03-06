<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array('attr' => array('placeholder' => 'Nom'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez saisir un nom valide.")),
                    new Length(array(
                        'min' => '2',
                        'minMessage' => 'Votre nom doit comporter au minimun {{ limit }} caractères.'
                    ))
                )
            ))
            ->add('prenom', TextType::class, array('attr' => array('placeholder' => 'Prénom'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez saisir un prénom valide.")),
                    new Length(array(
                        'min' => '2',
                        'minMessage' => 'Votre prénom doit comporter au minimun {{ limit }} caractères.'
                    ))
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Email'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez saisir une adresse mail valide.")),
                    new Email(array(
                        'checkMX' => true,
                        'message' => "Veuillez saisir une adresse mail valide.")),
                )
            ))
            ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Votre message'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez saisir un message valide.")),
                    new Length(array(
                        'min' => '2',
                        'max' => '10000',
                        'minMessage' => 'Votre message doit comporter au minimun {{ limit }} caractères.',
                        'maxMessage' => 'Votre message doit comporter au maximum {{ limit }} caractères.'
                    ))
                )
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'contact_form';
    }
}
