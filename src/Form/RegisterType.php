<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class,[
                'label'=>false,
                'constraints' => new Length([
                    'min'=> 2,
                    'max'=>30
                ]),
                'attr'=>[
                    'placeholder'  => 'Merci de saisir votre prenom'
                  ]
              ])
            ->add('nom', TextType::class,[
                'label' => false,
                'constraints' => new Length([
                    'min'=> 2,
                    'max'=>30
                ]),
                'attr'=>[
                  'placeholder'  => 'Merci de saisir votre nom'
                ]
            ])
            ->add('email', EmailType::class,[
                'label'=>false,
                'attr'=>[
                    'placeholder'  => 'Merci de saisir votre adresse email'
                  ]
              ])
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique!',
                'required' => true,
                'first_options' => [
                    'label' => false,
                    'attr'=>[
                        'placeholder'  => 'Merci de saisir votre mot de passe'
                      ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr'=>[
                        'placeholder'  => 'Merci de resaisir votre mot de passe'
                      ]
    
                ],
                
              ])
              ->add('submit',SubmitType::class,[
                'label' => "s'inscrire",
                'attr'=>[
                    'class'=>'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}