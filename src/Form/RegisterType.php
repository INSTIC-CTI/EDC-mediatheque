<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Type as TypeConstraint;

class RegisterType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('email', EmailType::class, [
        'label' => 'Email',
        'constraints' => [
          new Email(['message' => 'L\adresse email n\'est pas valide']),
          new NotBlank(['message' => 'L\'email doit être renseigné'])
        ]
      ])
      ->add('password', RepeatedType::class, [
        'type' => PasswordType::class,
        'invalid_message' => 'Les mots de passes ne sont pas identiques',
        'first_options' => ['label' => 'Mot de passe'],
        'second_options' => ['label' => "Confirmer le mot de passe"],
        'constraints' => [
          new Length(['min' => 5, 'max' => 25, 'minMessage' => 'Le mot de passe est trop court'])
        ]
      ])
      ->add('firstname')
      ->add('lastname')
      ->add('date_birth', DateType::class, [
        'label' => 'Date de naissance',
        'widget' => 'single_text',
        'constraints' => [
          new NotBlank(['message' => 'La date de naissance doit être renseigné']),
          new TypeConstraint(['DateTimeInterface'])
        ]
      ])
      ->add('address', TextareaType::class, [
        'label' => 'Adresse', 'attr' => [
          'placeholder' => '8 avenue de la pompe 34000 Curreau-sous-Seine'
        ],
        'constraints' => [
          new Length([
            'min' => 10,
            'max' => 100,
            'minMessage' => 'Adresse trop courte',
            'maxMessage' => 'Adresse trop longue'
          ]),
          new TypeConstraint(['string'])
        ]
      ])
      ->add('is_confirmed');
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }
}
