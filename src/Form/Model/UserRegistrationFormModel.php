<?php

    namespace App\Form\Model;

    use App\Validator\UniqueUser;
    use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Please enter an username")
     * @UniqueUser()
     */
    public $username;

    /**
     * @Assert\NotBlank(message="Please enter a name")
     */
    public $name;

    /**
     * @Assert\NotBlank(message="Choose a password!")
     * @Assert\Length(min=5, minMessage="Come on, you can think of a password longer than that!")
     */
    public $password;

    public $roles;
}
