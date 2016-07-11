<?php
namespace SFramework;


use InvalidArgumentException;
use SFramework\Models\Siteuser;
use SignInBase\Session\AuthenticatorAbstract;
use SORM\DataSource;

/**
 * Class AuthenticatorDB
 * @package SFramework
 */
class AuthenticatorDB extends AuthenticatorAbstract
{

    public $salt = 'B1-az#a^xzc1';

    public function __construct($salt = '')
    {
        parent::__construct();

        if (!empty($salt)) {
            $this->salt = $salt;
        }
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
            $this->setSessionKey($oSiteuser->id);
            return true;
        }

        return false;
    }

    /**
     * Get current siteuser
     *
     * @return Siteuser|null
     */
    public function getCurrentUser()
    {
        if ($this->hasSessionKey()) {
            return DataSource::i()->factory(Siteuser::cls(), (int)$this->getSessionKey());
        }

        return null;
    }

}