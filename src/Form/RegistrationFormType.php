<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, ['attr' =>
            ['placeholder' => 'Bilal51',
            'class' => 'form-username',
            ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les termes.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' =>
                ['autocomplete' => 'new-password',
                 'class' => 'form-password',
                 'placeholder' => 'Un mot de passe fort'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'merci d\'entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire plus de {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('street', TextType::class, ['attr' =>
            ['placeholder' => '6 rue de saint-brice',
            'class' => 'form-street' ]
            ])

            ->add('zipcode', NumberType::class, ['attr' =>
            ['placeholder' => '51100',
            'class' => 'form-zipcode' ]
            ])

            ->add('city', TextType::class, ['attr' =>
            ['placeholder' => 'Reims',
            'class' => 'form-city' ]
            ])

            ->add('email', TextType::class, ['attr' =>
            ['placeholder' => 'example@gmail.com',
            'class' => 'form-email' ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
