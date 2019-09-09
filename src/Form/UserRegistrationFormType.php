<?php

    namespace App\Form;

    use App\Entity\User;
    use App\Form\Model\UserRegistrationFormModel;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('name', TextType::class)
            ->add('roles', ChoiceType::class, [
                'choices' => $this->getRoles(),
                'multiple' => true,
                'required' => false,
            ])
            ->add('password', PasswordType::class);
    }

    private function getRoles()
    {
        return [
        "ROLE_ADMIN",
        "ROLE_USER",
        "ROLE_PAGE_1",
        "ROLE_PAGE_2",
        ];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRegistrationFormModel::class,
            'csrf_protection' => false,
        ]);
    }
}
