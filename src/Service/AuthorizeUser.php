<?php
namespace App\Service;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class AuthorizeUser
{
    private $user;

    public function __construct(Security $security, RouterInterface $router)
    {
        $this->user = $security->getUser();
    }

    public function isAuthorize()
    {
        if(!$this->user->isVerified()) {
            return false;
        } else {
            return true;
        }
    }
}
