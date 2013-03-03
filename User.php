<?php
/**
 * User Service
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\User;

defined('MOLAJO') or die;

/**
 * User Service
 *
 * 1. Gets User Data
 * 2. Loads arrays for authorised applications, groups, view_groups, extensions, extension_titles
 * 3. Loads arrays for parameters, customfields, and metadata
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 *
 * Usage
 *  -- for current visitor, whether they are logged in, or not
 *  -- automatically run during service startup
 *
 *  Services::User()->get($key);
 *  Services::User()->set($key, $value);
 *
 * Usage
 *  -- for any user
 *  -- new instance
 *
 *  $userInstance = User ($id);
 *  $userInstance->load();
 *
 *  echo $userInstance->get('username');
 *
 *  $userInstance->set($key, $value);
 */
Class User implements UserInterface
{
    /**
     * ID for visitor
     *
     * @var    string
     * @since  1.0
     */
    protected $id;

    /**
     * Parameters for User
     *
     * @var    array
     * @since  1.0
     */
    protected $password;

    /**
     * User Salt
     *
     * @var null|integer
     */
    protected $salt = null;

    /**
     * Language
     *
     * @var    array
     * @since  1.0
     */
    protected $language;

    /**
     * Administrator
     *
     * @var    string
     * @since  1.0
     */
    protected $administrator;

    /**
     * Authorised for Offline Access
     *
     * @var    string
     * @since  1.0
     */
    protected $authorised_for_offline_access;

    /**
     * Public
     *
     * @var    string
     * @since  1.0
     */
    protected $public;

    /**
     * Guest
     *
     * @var    string
     * @since  1.0
     */
    protected $guest;

    /**
     * Public
     *
     * @var    string
     * @since  1.0
     */
    protected $registered;

    /**
     * Model Registry
     *
     * @var    array
     * @since  1.0
     */
    protected $model_registry;

    /**
     * Data
     *
     * @var    array
     * @since  1.0
     */
    protected $data;

    /**
     * Parameters for User
     *
     * @var    array
     * @since  1.0
     */
    protected $parameters = array();

    /**
     * Metadata for User
     *
     * @var    array
     * @since  1.0
     */
    protected $metadata = array();

    /**
     * Authorised Applications for User
     *
     * @var    string
     * @since  1.0
     */
    protected $applications = array();

    /**
     * Authorised Groups for User
     *
     * @var    string
     * @since  1.0
     */
    protected $groups = array();

    /**
     * Authorised View Groups for User
     *
     * @var    array
     * @since  1.0
     */
    protected $view_groups = array();

    /**
     * Authorised Extensions for User
     *
     * @var    array
     * @since  1.0
     */
    protected $authorised_extensions = array();

    /**
     * Authorised Extension Titles for User
     *
     * @var    array
     * @since  1.0
     */
    protected $authorised_extension_titles = array();

    /**
     * The user's state ID
     *
     * @var null
     */
    protected $user_state = null;


    protected $used = null;

    protected $date_used = null;

    protected $token = null;

    var $remTime = 2592000; //One month
    /**
     * The name of the cookie which we will use if user wants to be remembered by the system
     * var string
     */
    var $remCookieName = 'ckSavePass';
    /**
     * The cookie domain
     * var string
     */
    var $remCookieDomain = '';
    /**
     * The method used to encrypt the password. It can be sha1, md5 or nothing (no encryption)
     * var string
     */
    var $passMethod = 'sha1';


    /**
     * List of Properties
     *
     * @var    object
     * @since  1.0
     */
    protected $property_array = array(
        'id',
        'password',
        'language',
        'authorised_for_offline_access',
        'public',
        'guest',
        'registered',
        'administrator',
        'model_registry',
        'data',
        'parameters',
        'metadata',
        'applications',
        'groups',
        'view_groups',
        'authorised_extensions',
        'authorised_extension_titles'
    );

    /**
     * Construct
     *
     * @param   $id
     *
     * @return  void
     * @since   1.0
     */
    public function __construct($id = 0)
    {
        $this->id = (int)$id;

        return;
    }

    /**
     * Get the current value (or default) of the specified key
     *
     * @param   string  $key
     * @param   mixed   $default
     *
     * @return  mixed
     * @since   1.0
     * @throws  \OutOfRangeException
     */
    public function get($key = null, $default = null)
    {
        $key = strtolower($key);

        if (in_array($key, $this->property_array)) {
            if (isset($this->$key)) {
            } else {
                $this->$key = $default;
            }

            return $this->$key;
        }

        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        if (isset($this->metadata[$key])) {
            return $this->metadata[$key];
        }

        if (isset($this->parameters[$key])) {
            return $this->parameters[$key];
        }

        $this->parameters[$key] = $default;

        return $this->parameters[$key];
    }

    /**
     * Set the value of a specified key
     *
     * @param   string  $key
     * @param   mixed   $value
     *
     * @return  mixed
     * @since   1.0
     * @throws  \OutOfRangeException
     */
    public function set($key, $value = null)
    {
        $key = strtolower($key);

        if (in_array($key, $this->property_array)) {
            $this->$key = $value;

            return $this->$key;
        }

        if (isset($this->data[$key])) {
            $this->data[$key] = $value;

            return $this->data[$key];
        }

        if (isset($this->metadata[$key])) {
            $this->metadata[$key] = $value;

            return $this->metadata[$key];
        }

        $this->parameters[$key] = $value;

        return $this->parameters[$key];
    }

    /**
     * Checks to see that the user is authorised to use this extension
     *
     * @param   string  $extension_instance_id
     *
     * @return  bool
     * @since   1.0
     */
    public function checkAuthorised($extension_instance_id)
    {
        if (in_array($extension_instance_id, $this->authorised_extensions)) {
            return $this->authorised_extensions[$extension_instance_id];
        }

        return false;
    }

    /**
     * Get data for site visitor (user or guest)
     *
     * @returns  void
     * @since    1.0
     * @throws   UserException
     */
    public function getUserData()
    {
        if (is_object($this->data)) {
        } else {
            throw new UserException ('User Service: Load User Query Failed');
        }

        $this->language = $this->data->language;
        if ($this->language == '') {
            $this->language = 'en-GB';
        }
        $this->setApplications();

        $this->setGroups();

        $this->setViewgroups();

        if ($this->get('id', 0) == 0) {
            $this->set('public', 1);
            $this->set('guest', 1);
            $this->set('registered', 0);

        } else {
            $this->set('public', 1);
            $this->set('guest', 0);
            $this->set('registered', 1);
        }

        return;
    }

    /**
     * Set Applications for which User is Authorised to Login
     *
     * @return  void
     * @since   1.0
     * @throws  UserException
     */
    protected function setApplications()
    {
        $this->applications = array();

        $x = $this->data->Userapplications;

        if (count($x) > 0) {
            foreach ($x as $app) {
                $this->applications[] = $app->application_id;
            }
        }

        array_unique($this->applications);

        if (count($this->applications) == 0) {
            throw new UserException ('User Service: User is not authorised for any applications.');
        }

        unset($this->data->Userapplications);

        return;
    }

    /**
     * Set Groups the User is authorised for
     *
     * @return  array
     * @since   1.0
     * @throws  UserException
     */
    protected function setGroups()
    {
        $temp = array();

        $x = $this->data->Usergroups;

        if (count($x) > 0) {
            foreach ($x as $group) {
                $temp[] = $group->group_id;
            }
        }

        if (in_array(SYSTEM_GROUP_PUBLIC, $temp)) {
        } else {
            $temp[] = SYSTEM_GROUP_PUBLIC;
        }

        if ($this->id == 0) {
            $temp[] = SYSTEM_GROUP_GUEST;
        } else {
            if (in_array(SYSTEM_GROUP_REGISTERED, $temp)) {
            } else {
                $temp[] = SYSTEM_GROUP_REGISTERED;
            }
        }

        unset($this->data->Usergroups);

        if (in_array(SYSTEM_GROUP_ADMINISTRATOR, $temp)) {
            $this->set('administrator', 1);
            $this->set('authorised_for_offline_access', 1);

        } else {
            $this->set('administrator', 0);
            $this->set('authorised_for_offline_access', 0);
        }

        $temp2 = array_unique($temp);

        $this->set('groups', $temp2);

        return;
    }

    /**
     * Set View Groups the User is authorised for
     *
     * @return  array
     * @since   1.0
     * @throws  UserException
     */
    protected function setViewgroups()
    {
        $temp = array();
        $x    = $this->data->Userviewgroups;
        if (count($x) > 0) {
            foreach ($x as $vg) {
                $temp[] = $vg->view_group_id;
            }
        }

        $temp[] = SYSTEM_GROUP_PUBLIC;

        if (in_array(SYSTEM_GROUP_REGISTERED, $temp)) {
        } else {
            $temp[] = SYSTEM_GROUP_GUEST;
        }

        unset($this->data->Userviewgroups);

        $temp2 = array_unique($temp);

        $this->set('view_groups', $temp2);

        return $this->data;
    }

    /**
     * Find a user record by its ID
     *
     * @param $userID
     *
     * @return mixed
     */
    public function findByID($userID)
    {
        return $this->find($userID);
    }

    /**
     * Get a user entity by its ID
     *
     * @param $userID
     *
     * @return mixed
     * @throws \Exception
     */
    public function getByID($userID)
    {
        $row = $this->find($userID);
        if ($row === false) {
            throw new \Exception('Unable to obtain user row for id: ' . $userID);
        }

        return new UserEntity($row);

    }

    /**
     * Find a user record by the email
     *
     * @param  string $email
     *
     * @return mixed
     */
    public function findByEmail($email)
    {
        return $this->createQueryBuilder()
            ->select('u.*')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.email = :email')->setParameter(':email', $email)
            ->execute()
            ->fetch($this->getFetchMode());
    }

    /**
     * Get a user entity by the email address
     *
     * @param  string     $email
     *
     * @return mixed
     * @throws \Exception
     */
    public function getByEmail($email)
    {
        $row = $this->findByEmail($email);

        if ($row === false) {
            throw new \Exception('Unable to find user record by email: ' . $email);
        }

        return new UserEntity($row);

    }

    /**
     * Check if a user record exists by email address
     *
     * @param $email
     *
     * @return bool
     */
    public function existsByEmail($email)
    {
        $row = $this->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.email = :email')
            ->setParameter(':email', $email)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;
    }

    /**
     * Delete a user by their email address
     *
     * @param  string $email
     *
     * @return mixed
     */
    public function deleteByEmail($email)
    {
        return $this->delete(array('email' => $email));
    }

    /**
     * Create a user record
     *
     * @param  array $userData
     *
     * @return mixed
     */
    public function create(array $userData, $configSalt)
    {

        // Override the plaintext pass with the encrypted one
        $userData['password'] = $this->saltPass($userData['salt'], $configSalt, $userData['password']);

        return $this->insert($userData);
    }


    /**
     * Check the authentication fields to make sure things auth properly
     *
     * @param string $email
     * @param string $password
     * @param string $configSalt
     *
     * @return boolean
     */
    function checkAuth($email, $password, $configSalt)
    {

        $user = $this->findByEmail($email);

        if (empty($user)) {
            return false;
        }

        $encPass = $this->saltPass($user['salt'], $configSalt, $password);
        $row     = $this->_conn->createQueryBuilder()
            ->select('count(id) as total')
            ->from($this->getTableName(), 'u')
            ->andWhere('u.email = :email')
            ->andWhere('u.password = :password')
            ->setParameter(':email', $email)
            ->setParameter(':password', $encPass)
            ->execute()
            ->fetch($this->getFetchMode());

        return $row['total'] > 0;
    }


    public function logoutAction()
    {
        $this->getSession()->clear();
        $this->redirectToRoute('Homepage');
    }

    public function signupsaveAction()
    {

        $errors       = $missingFields = array();
        $post         = $this->post();
        $requiredKeys = array(
            'userTitle',
            'userFirstName',
            'userLastName',
            'userEmail',
            'userPassword',
            'userConfirmPassword'
        );
        $userStorage  = $this->getUserStorage();

        // Check for missing fields, or fields being empty.
        foreach ($requiredKeys as $field) {
            if (! isset($post[$field]) || empty($post[$field])) {
                $missingFields[] = $field;
            }
        }

        // If any fields were missing, inform the client
        if (! empty($missingFields)) {
            $errors[] = 'Missing fields';
            return $this->render('User:auth:signup.html.php', compact('errors'));
        }

        // Check if the user's passwords do not match
        if ($post['userPassword'] !== $post['userConfirmPassword']) {
            $errors[] = 'Passwords do not match';
            return $this->render('User:auth:signup.html.php', compact('errors'));
        }

        // Check if the user's email address already exists
        if ($userStorage->existsByEmail($post['userEmail'])) {
            $errors[] = 'That email address already exists';
            return $this->render('User:auth:signup.html.php', compact('errors'));
        }

        // Prepare user array for insertion
        $user = array(
            'title'     => $post['userTitle'],
            'email'     => $post['userEmail'],
            'firstname' => $post['userFirstName'],
            'lastname'  => $post['userLastName'],
            'password'  => $post['userPassword'],
            'salt'      => base64_encode(openssl_random_pseudo_bytes(16))
        );

        // Create the user
        $newUserID = $userStorage->create($user, $this->getConfigSalt());

        // Generate sha1() based activation code
        $activationCode = sha1(openssl_random_pseudo_bytes(16));

        // Insert an activation token for this user
        $this->getUserActivationStorage()->create(
            array(
                'user_id' => $newUserID,
                'token'   => $activationCode
            )
        );

        // Send the user's activation email
        $this->sendActivationEmail($user, $activationCode);

        // Successful registration. \o/
        return $this->render('User:auth:signupsuccess.html.php');

    }

    public function logincheckAction()
    {

        $errors       = $missingFields = array();
        $post         = $this->post();
        $requiredKeys = array('userEmail', 'userPassword');
        $userStorage  = $this->getUserStorage();

        // Check for missing fields, or fields being empty.
        foreach ($requiredKeys as $field) {
            if (! isset($post[$field]) || empty($post[$field])) {
                $missingFields[] = $field;
            }
        }

        // If any fields were missing, inform the client
        if (! empty($missingFields)) {
            $errors[] = 'Missing fields';
            return $this->render('User:auth:login.html.php', compact('errors'));
        }

        // Lets try to authenticate the user
        if (! $userStorage->checkAuth($post['userEmail'], $post['userPassword'], $this->getConfigSalt())) {
            $errors[] = 'Login Invalid';
            return $this->render('User:auth:login.html.php', compact('errors'));
        }

        // Get user record
        $userEntity = $userStorage->getByEmail($post['userEmail']);

        // Check if user is activated
        if (! $this->getUserActivationStorage()->isActivated($userEntity->getID())) {
            $errors[] = 'Account not activated';
            return $this->render('User:auth:login.html.php', compact('errors'));
        }

        // Lets populate the session with the user's auth information
        $this->setAuthData(new AuthUserEntity($userStorage->findByEmail($post['userEmail'])));

        // Login Successful. \o/
        $this->setFlash('success', 'Login Successful');
        $this->redirectToRoute('Homepage');

    }

    public function forgotpwsendAction()
    {

        $response = array('status' => 'E_UNKNOWN');
        $email    = $this->post('email');
        $us       = $this->getUserStorage();

        // Check for missing field
        if (empty($email)) {
            $response['status']      = 'E_MISSING_FIELD';
            $response['error_value'] = 'email';
            $this->renderJsonResponse($response);
        }

        // Check if user record does not exist
        if (! $us->existsByEmail($email)) {
            $response['status'] = 'E_MISSING_RECORD';
            $this->renderJsonResponse($response);
        }

        $forgotUser  = $us->getByEmail($email);
        $forgotToken = sha1(openssl_random_pseudo_bytes(16));

        // Insert a forgot token for this user
        $this->getUserForgotStorage()->create(
            array(
                'user_id' => $forgotUser->getID(),
                'token'   => $forgotToken
            )
        );

        // Lets send the user forgotpw email
        $this->sendForgotPWEmail($forgotUser, $forgotToken);

        // Successful response
        $response['status'] = 'success';
        $this->renderJsonResponse($response);

    }

    public function forgotpwcheckAction()
    {

        $token = $this->getRouteParam('token');
        $fs    = $this->getUserForgotStorage();

        // If the user has not activated their token before, activate it!
        if (! $fs->isUserActivatedByToken($token)) {

            $fs->useToken($token);

            // Lets generate a CSRF token for the update password page.
            $csrf = sha1(openssl_random_pseudo_bytes(16));
            $this->getSession()->set('forgotpw_csrf', $csrf);
            $this->getSession()->set('forgotpw_token', $token);

            // Render the 'enter your new password' view
            return $this->render('User:auth:forgotpwenter.html.php', compact('csrf'));
        }

        // redirect the user to the login page
        $this->redirectToRoute('User_Signup');
    }

    public function forgotpwsaveAction()
    {

        $post         = $this->post();
        $requiredKeys = array('password', 'confirm_password', 'csrf');

        // Check for missing fields, or fields being empty.
        foreach ($requiredKeys as $field) {
            if (! isset($post[$field]) || empty($post[$field])) {
                $missingFields[] = $field;
            }
        }

        // If any fields were missing, inform the client
        if (! empty($missingFields)) {
            $response['status']      = 'E_MISSING_FIELD';
            $response['error_value'] = implode(',', $missingFields);
            $this->renderJsonResponse($response);
        }

        // Check if both passwords match
        if ($post['password'] !== $post['confirm_password']) {
            $response['status'] = 'E_PASSWORD_MISMATCH';
            $this->renderJsonResponse($response);
        }

        // Check for csrf protection
        $csrf = $this->session('forgotpw_csrf');
        if (empty($csrf) || $csrf !== $post['csrf']) {
            $response['status'] = 'E_INVALID_CSRF';
            $this->renderJsonResponse($response);
        }

        // Get the user record out of the session token
        $token = $this->session('forgotpw_token');
        if (empty($token)) {
            $response['status'] = 'E_MISSING_TOKEN';
            $this->renderJsonResponse($response);
        }

        // Get user entity from the userID on the token row
        $us         = $this->getUserStorage();
        $userEntity = $us->getByID($this->getUserForgotStorage()->getByToken($token)->getUserID());

        // Update the user's password
        $this->getUserStorage()->updatePassword(
            $userEntity->getID(),
            $userEntity->getSalt(),
            $this->getConfigSalt(),
            $post['password']
        );

        // Wipe session values clean
        $session = $this->getSession();
        $session->remove('fogotpw_csrf');
        $session->remove('fogotpw_token');

        // Return successful response \o/
        $response['status'] = 'success';
        $this->renderJsonResponse($response);

    }

    /**
     * Activation action. Active the user's account
     */
    public function activateAction()
    {

        $token = $this->getRouteParam('token');
        $uas   = $this->getUserActivationStorage();

        // If the user has not activated their token before, activate it!
        if (! $uas->isUserActivatedByToken($token)) {
            $uas->activateUser($token);
        }

        return $this->render('User:auth:activate.html.php', compact('csrf'));

    }

    /**
     * Send the user's activation email to them.
     *
     * @param \User\Entity\User $toUser
     * @param string            $activationCode
     */
    protected function sendActivationEmail($toUser, $activationCode)
    {

        $fromUser = new UserEntity($this->getEmailConfig());
        $toUser   = new UserEntity($toUser);

        // Generate the activation link from the route key
        $activationLink = $this->generateUrl('User_Activate', array('token' => $activationCode), true);

        // Get the activation email content, it's in a view file.
        $emailContent = $this->render('User:auth:signupemail.html.php', compact('toUser', 'activationLink'));

        // Send the activation email to the user
        $helper = new \User\Classes\Email();
        $config = $this->getConfig();
        $helper->sendEmail($fromUser, $toUser, $config['signupEmail']['subject'], $emailContent);

    }

    /**
     * Send the user's forgotpw email to them.
     *
     * @param \User\Entity\User|array $toUser
     * @param string                  $activationCode
     *
     * @return void
     */
    protected function sendForgotPWEmail($toUser, $forgotToken)
    {

        // User entity preparation
        $fromUser = new UserEntity($this->getEmailConfig());
        if (is_array($toUser)) {
            $toUser = new UserEntity($toUser);
        }

        // Generate the activation link from the route key
        $forgotLink = $this->generateUrl('User_Forgot_Password_Check', array('token' => $forgotToken), true);

        // Get the activation email content, it's in a view file.
        $emailContent = $this->render('User:auth:forgotpwemail.html.php', compact('toUser', 'forgotLink'));

        // Send the activation email to the user
        $helper = new \User\Classes\Email();
        $config = $this->getConfig();
        $helper->sendEmail($fromUser, $toUser, $config['forgotEmail']['subject'], $emailContent);

    }


}
