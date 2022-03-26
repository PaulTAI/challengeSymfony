<?php

namespace App\Controller;

use App\Service\UserService;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AsyncController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/deleteUser/{id}", name="async_delete_user")
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteUser(int $id): Response
    {
        $this->userService->deleteUser($id);

        return $this->redirectToRoute('bo_users');
    }

    /**
     * @Route("/makeAdmin/{id}", name="async_up_to_admin_user")
     * @isGranted("ROLE_ADMIN")
     */
    public function AdminUser(int $id): Response
    {
        $this->userService->upgradeToAdmin($id);

        return $this->redirectToRoute('bo_users');
    }
}