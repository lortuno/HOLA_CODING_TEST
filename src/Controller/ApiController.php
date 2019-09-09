<?php

    namespace App\Controller;

    use App\Entity\User;
    use App\Form\Model\UserRegistrationFormModel;
    use App\Form\UserRegistrationFormType;
    use App\Repository\UserRepository;
    use App\Service\UserService;
    use Doctrine\ORM\EntityManagerInterface;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

    /**
     * Class ApiController
     * @package App\Controller
     */
class ApiController extends BaseController
{
    /**
     * @Route("/api/user/create", name="api_user_new", schemes={"https"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function createUser(UserPasswordEncoderInterface $passwordEncoder, Request $request)
    {
        $userForm = new UserRegistrationFormModel();
        $form = $this->createForm(UserRegistrationFormType::class, $userForm);
        $this->processForm($request, $form);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $userService = new UserService($this->getDoctrine()->getManager());
            return $userService->saveUserData(
                $user,
                $form,
                $passwordEncoder,
                201,
                'User Created'
            );
        } else {
            return new JsonResponse('Error on User Created', 400);
        }
    }

    /**
     * @Route("/api/user/{id}/edit", name="api_user_edit", methods={"PATCH","POST"}, schemes={"https"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $id = $request->get('id');
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            throw new NotFoundHttpException('USER_NOT_FOUND');
        }

        $userForm = new UserRegistrationFormModel();
        $form = $this->createForm(UserRegistrationFormType::class, $userForm);
        $this->processForm($request, $form);

        if ($form->isSubmitted()) {
            $userService = new UserService($em);
            return $userService->saveUserData(
                $user,
                $form,
                $passwordEncoder,
                200,
                'User ' . $user->getId() . ' Edited'
            );
        } else {
            return new JsonResponse('Error on User Edition', 400);
        }
    }

    /**
     * @Route("/api/user/{id}/delete", name="api_user_delete", schemes={"https"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, EntityManagerInterface $em)
    {
        $id = $request->get('id');
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            throw new NotFoundHttpException('USER_NOT_FOUND');
        }

        try {
            $em->remove($user);
            $em->flush();

            return new JsonResponse('USER_DELETED', 204);
        } catch (\Exception $e) {
            throw new NotFoundHttpException('Error on delete');
        }
    }

    /**
     * @Route("/api/users", name="api_user_list", schemes={"https"})
     */
    public function select(UserRepository $userRepo)
    {
        $users = $userRepo->findAllUsernameAlphabetical();

        if ($users) {
            return new JsonResponse($users, 201);
        }

        return new JsonResponse('Error on User Select', 400);
    }
}
