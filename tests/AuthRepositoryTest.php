<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */
class AuthRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->setupData();
    }

    protected function setupData()
    {
        $roleData = [
            'name' => 'Registered',
            'slug' => 'registered',
        ];

        $userData = [
            'email'                 => 'admin@change.me',
            'password'              => 'test',
            'password_confirmation' => 'test',
        ];

        $this->role->create($roleData);
        $this->auth->registerAndActivate($userData);
    }

    public function testGetActiveUser()
    {
        $userData = [
            'email'    => 'admin@change.me',
            'password' => 'test',
        ];

        $user = $this->auth->authenticate($userData);
        $this->auth->login($user);
        $activeUser = $this->auth->getActiveUser();

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $activeUser);
    }

    public function testCheckTrue()
    {
        $userData = [
            'email'    => 'admin@change.me',
            'password' => 'test',
        ];

        $user = $this->auth->authenticate($userData);
        $this->auth->login($user);
        $check = $this->auth->check();

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $check);
    }

    public function testCheckFalse()
    {
        $this->assertFalse($this->auth->check());
    }

    public function testAuthenticate()
    {
        $userData = [
            'email'    => 'admin@change.me',
            'password' => 'test',
        ];

        $user = $this->auth->authenticate($userData);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $user);
    }

    public function testAuthenticateFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $userData = [
            'email'    => 'admin',
            'password' => 'test',
        ];

        $this->auth->authenticate($userData);
    }

    public function testAuthenticateAuthenticationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\AuthenticationException');

        $userData = [
            'email'    => 'admin@change.me',
            'password' => 'test2',
        ];

        $this->auth->authenticate($userData);
    }

    public function testRegister()
    {
        config(['laraflock.dashboard.activations' => true]);

        $data = [
            'email'                 => 'admin2@change.me',
            'password'              => 'test',
            'password_confirmation' => 'test',
            'role'                  => 'registered',
        ];

        $activation = $this->auth->register($data);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Activations\EloquentActivation::class, $activation);
    }

    public function testRegisterFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $data = [
            'email'                 => 'admin@change.me',
            'password'              => 'test',
            'password_confirmation' => 'test',
            'role'                  => 'registered',
        ];

        $this->auth->register($data);
    }

    public function testRegisterRolesException()
    {
        config(['laraflock.dashboard.activations' => true]);

        $this->setExpectedException('Laraflock\Dashboard\Exceptions\RolesException');

        $data = [
            'email'                 => 'admin2@change.me',
            'password'              => 'test',
            'password_confirmation' => 'test',
            'role'                  => 'administrator',
        ];

        $this->auth->register($data);
    }

    public function testRegisterAndActivate()
    {
        $data = [
            'email'                 => 'admin2@change.me',
            'password'              => 'test',
            'password_confirmation' => 'test',
            'role'                  => 'registered',
        ];

        $user = $this->auth->register($data);

        $this->assertTrue($user);
    }

    public function testRegisterAndActivateFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $data = [
            'email'                 => 'admin',
            'password'              => 'test',
            'password_confirmation' => 'test',
            'role'                  => 'registered',
        ];

        $this->auth->registerAndActivate($data);
    }

    public function testRegisterAndActivateRolesException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\RolesException');

        $data = [
            'email'                 => 'admin2@change.me',
            'password'              => 'test',
            'password_confirmation' => 'test',
            'role'                  => 'administrator',
        ];

        $this->auth->registerAndActivate($data);
    }

    public function testActivate()
    {
        config(['laraflock.dashboard.activations' => true]);

        $data = [
            'email'                 => 'admin2@change.me',
            'password'              => 'test',
            'password_confirmation' => 'test',
            'role'                  => 'registered',
        ];

        $activation = $this->auth->register($data);

        $activationData = [
            'email'           => $data['email'],
            'activation_code' => $activation->code,
        ];

        $activated = $this->auth->activate($activationData);

        $this->assertTrue($activated);
    }

    public function testActivateAuthenticationException()
    {
        config(['laraflock.dashboard.activations' => true]);

        $this->setExpectedException('Laraflock\Dashboard\Exceptions\AuthenticationException');

        $data = [
            'email'                 => 'admin2@change.me',
            'password'              => 'test',
            'password_confirmation' => 'test',
            'role'                  => 'registered',
        ];

        $this->auth->register($data);

        $activationData = [
            'email'           => $data['email'],
            'activation_code' => 'notthecode',
        ];

        $this->auth->activate($activationData);
    }

    public function testFindUserByCredentials()
    {
        $user = $this->auth->findByCredentials(['login' => 'admin@change.me']);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $user);
    }

    public function login()
    {
        $userData = [
            'email'    => 'admin@change.me',
            'password' => 'test',
        ];

        $user = $this->auth->authenticate($userData);
        $loginUser = $this->auth->login($user);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Users\EloquentUser::class, $loginUser);
    }

    public function logout()
    {
        $userData = [
            'email'    => 'admin@change.me',
            'password' => 'test',
        ];

        $user = $this->auth->authenticate($userData);
        dd($this->auth->logout($user));
    }
}