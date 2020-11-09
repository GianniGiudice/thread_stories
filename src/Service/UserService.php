<?php


namespace App\Service;


use App\Entity\Avatar;
use App\Entity\Banner;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class UserService
{
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    /**
     * @return Avatar
     */
    public function getAvatar(): Avatar
    {
        /** @var User $user */
        $user = $this->user;

        $avatar = new Avatar();
        $avatar->setOwner($user);
        if ($user->getAvatar()) {
            $avatar = $user->getAvatar();
        }

        return $avatar;
    }

    /**
     * @return Banner
     */
    public function getBanner(): Banner
    {
        /** @var User $user */
        $user = $this->user;

        $banner = new Banner();
        $banner->setOwner($user);
        if ($user->getBanner()) {
            $banner = $user->getBanner();
        }

        return $banner;
    }
}