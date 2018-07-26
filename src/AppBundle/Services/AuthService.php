<?php
/**
 * Created by PhpStorm.
 * User: brosako
 * Date: 7/26/18
 * Time: 3:17 PM
 */

namespace AppBundle\Services;


use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class AuthService
{
    const AUTHORIZATION_HEADER = 'Authorization';
    const AUTHORIZATION_HEADER_DELIMITER = ':';

    private $user;

    private $requestStack;

    private $userRepository;

    public function __construct(RequestStack $requestStack, UserRepositoryInterface $userRepository)
    {
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
    }

    /**
     * @return User|false
    */
    public function getUser() {
        if (!$this->user) {
            $request = $this->requestStack->getCurrentRequest();
            $authValue = $request->headers->get(self::AUTHORIZATION_HEADER);

            if (!$authValue) {
                return false;
            }

            $authValue = str_replace('Basic ', null, trim($authValue));
            $authValue = base64_decode($authValue);

            $authData = explode(self::AUTHORIZATION_HEADER_DELIMITER, $authValue);
            $email = $authData[0] ?? null;
            $password = $authData[1] ?? null;

            if (!$email || !$password) {
                return false;
            }

            $user = $this->userRepository->findByEmailAndPassword($email, $password);

            if ($user) {
                $this->user = $user;
                return $user;
            }
        }

        return $this->user;
    }
}