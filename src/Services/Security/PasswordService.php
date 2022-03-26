<?php

namespace App\Service\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordService
{
    private $passwordHash;
    private $userRepository;

    public function __construct(UserPasswordHasherInterface $passwordHash, UserRepository $userRepository)
    {
        $this->passwordHash = $passwordHash;
        $this->userRepository = $userRepository;
    }

    /**
     * update user password
     * 
     * @param string $mail user mail
     * @param string $newPassword new user password
     * 
     */
    public function updatePassword(string $mail, string $newPassword)
    {
        $user = new User();

        $password = $this->passwordHash->hashPassword(
            $user,
            $newPassword
        );

        $this->userRepository->updatePasswordWithUserMail($mail, $password);
    }

    public function maxLength($len)
    {
        $func = function ($value) use ($len) {
            return strlen($value) <= $len;
        };
        return $func;
    }

    /**
     * generate password
     * 
     * @return string
     */
    public function generatePassword()
    {
        $faker = \Faker\Factory::create();
        $randomPass = $faker->valid((new ValidatorService())->checkPassword())->password();

        return $randomPass;
    }

    /**
     * hash password
     * 
     * @return string hashed password
     */
    public function hashPassword(User $user)
    {
        return $this->passwordHash->hashPassword($user, $user->getPassword());
    }

    /**
     * decrypt password
     * 
     * @return string hashed password
     */
    public function decryptPassword(string $password)
    {
        return base64_decode($password);
    }

    /**
     * Check if passwords are the same
     *
     */
    public function checkPassword(User $user, $pass)
    {
        return $this->passwordHash->isPasswordValid($user, $pass);
    }
}
