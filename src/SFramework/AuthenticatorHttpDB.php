<?php
namespace SFramework;


use Exception;
use InvalidArgumentException;
use SFramework\Models\Siteuser;
use SignInBase\AuthenticatorAbstract;
use SORM\DataSource;

class AuthenticatorHttpDB extends AuthenticatorAbstract
{

    /**
     * Check user authentication
     * @return bool
     * @throws Exception
     */
    public function authenticated()
    {
        throw new Exception('Authenticated is not available for this authenticate method.');
    }

    /**
     * Get current siteuser
     * @return mixed
     * @throws Exception
     */
    public function getCurrentUser()
    {
        throw new Exception('Get current user is not available for this authenticate method.');
    }

    /**
     * Sign in
     *
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function signIn($login, $password)
    {
        if (!is_string($login)) {
            throw new InvalidArgumentException('Login must be a string.');
        }

        if (!is_string($password)) {
            throw new InvalidArgumentException('Password must be a string.');
        }

        $oSiteusers = DataSource::i()->factory(Siteuser::cls());
        $oSiteusers->getQueryBuilder()->where('login', '=', '?');
        /** @var Siteuser[] $aSiteusers */
        $aSiteusers = $oSiteusers->loadAll([$login]);
        if (empty($aSiteusers)) {
            return false;
        }

        $oSiteuser = $aSiteusers[0];
        if($this->verifyPassword($password, $this->salt, $oSiteuser->password)) {
            return true;
        }

        return false;
    }

    /**
     * Sign out
     * @return bool
     * @throws Exception
     */
    public function signOut()
    {
        throw new Exception('Sign out is not available for this authenticate method.');
    }

}