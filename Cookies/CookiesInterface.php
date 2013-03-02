<?php
/**
 * Cookies Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Service\Adapter;

defined('MOLAJO') or die;

/**
 * Cookie Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface CookiesInterface
{
    /**
     *
     * Set the session cookie params
     *
     * Where params as
     *
     * lifetime : Lifetime of the session cookie, defined in seconds.
     *
     * path : Path on the domain where the cookie will work.
     * Use a single slash ('/') for all paths on the domain.
     *
     * domain : Cookie domain, for example 'www.php.net'.
     * To make cookies visible on all subdomains then the domain must be
     * prefixed with a dot like '.php.net'.
     *
     * secure : If TRUE cookie will only be sent over secure connections.
     *
     * httponly : If set to TRUE then PHP will attempt to send the httponly
     * flag when setting the session cookie.
     *
     * @param array $params
     *
     */

    public function setCookieParams(array $params)
    {
        $this->cookie_params = array_merge($this->cookie_params, $params);
        session_set_cookie_params(
            $this->cookie_params['lifetime'],
            $this->cookie_params['path'],
            $this->cookie_params['domain'],
            $this->cookie_params['secure'],
            $this->cookie_params['httponly']
        );
    }

    /**
     * Instantiate Service Class
     *       returns $this->cookie_params;
     *
     * @return  void
     * @since   1.0
     */
    public function getCookieParams();


}
