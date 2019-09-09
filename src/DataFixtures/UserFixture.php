<?php

    namespace App\DataFixtures;

    use App\Entity\ApiToken;
    use App\Entity\User;
    use Doctrine\Common\Persistence\ObjectManager;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends BaseFixture
{
    private $passwordEncoder;

    private static $userRoles = [
        'ROLE_ADMIN',
        'ROLE_PAGE_1',
        'ROLE_PAGE_2',
    ];

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createFirstAdmin($manager);

        $this->createMany(3, 'admin_users', function ($i) use ($manager) {
            $user = new User();
            $user->setName($this->faker->firstName);
            $user->setUsername(sprintf('admin%d@hola.com', $i));
            $user->setRoles([$this->faker->randomElement(self::$userRoles)]);

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'adminpassword'
            ));

            $this->setApiToken($user, $manager);


            return $user;
        });



        $manager->flush();
    }

    private function createFirstAdmin($manager)
    {
        $this->createMany(1, 'admin_main_user', function ($i) use ($manager) {
            $user = new User();
            $user->setName('Admin');
            $user->setUsername('admin');
            $user->setRoles([self::$userRoles[0]]);

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'adminpassword'
            ));

            $this->setApiToken($user, $manager);

            return $user;
        });
    }

    private function setApiToken($user, $manager)
    {
        $apiToken1 = new ApiToken($user);
        $manager->persist($apiToken1);
    }
}
