<?php

    namespace App\Service;

    use App\Entity\User;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function saveUserData(
        User $user,
        $form,
        UserPasswordEncoderInterface $passwordEncoder,
        $successStatus = 200,
        $msg = 'OK'
    ) {
        $userModel = $form->getData();

        $user->setUsername($userModel->username);
        $user->setName($userModel->name);
        $user->setPassword($passwordEncoder->encodePassword(
            $user,
            $userModel->password
        ));
        $user->setRoles(($userModel->roles) ? $userModel->roles : []);

        $em = $this->em;
        $em->persist($user);
        try {
            $em->flush();
            return new JsonResponse($msg, $successStatus);
        } catch (\Exception $e) {
            return new JsonResponse('Error on Saving the User', 500);
        }
    }
}
