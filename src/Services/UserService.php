<?php

namespace App\Service;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class UserService
{

    private $userRepository;
    private $security;

    public function __construct(UserRepository $userRepository, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }


    /**
     * Delete User by id
     * 
     * 
     */
    public function deleteUser($id)
    {
        $this->userRepository->deleteUser($id);
    }

    /**
     * Upagrade user to Admin in boosterlist
     *
     * @param integer $id
     * @return void
     */
    public function upgradeToAdmin(int $id)
    {
        $this->userRepository->setRole(array('ROLE_ADMIN'), $id);
    }

    /**
     * Return name of the user
     * @param integer $id
     * @return array
     */
    public function nameUserById(int $id){
        $user = $this->userRepository->getUserName($id);
        
        return $user;
    }

    /**
     * Check if the role = Role with id user
     *
     * @param string $role
     * @param integer $id
     * @return boolean
     */
    public function isRole(string $role, int $id = null)
    {
        if ($id === null) {
            $roles = $this->security->getUser()->getRoles();
        } else {
            $roles = $this->userRepository->getUserRolesById($id);
        }

        return in_array($role, $roles);
    }
}
