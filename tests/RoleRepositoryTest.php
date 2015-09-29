<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

class RoleRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->setupData();
    }

    protected function setupData()
    {
        $data = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $this->role->create($data);
    }

    public function testGetAll()
    {
        $roles = $this->role->all();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $roles);
    }

    public function testGetById()
    {
        $role = $this->role->find(1);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Roles\EloquentRole::class, $role);
    }

    public function testGetByIdNull()
    {
        $role = $this->role->find(2);

        $this->assertNull($role);
    }

    public function testCreate()
    {
        $data = [
          'name' => 'Administrator',
          'slug' => 'admin',
        ];

        $role = $this->role->create($data);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Roles\EloquentRole::class, $role);
    }

    public function testCreateFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $data = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $this->role->create($data);
    }

    public function testUpdate()
    {
        $data = [
          'name' => 'Registered2',
          'slug' => 'registered',
        ];

        $role = $this->role->update(1, $data);

        $this->assertInstanceOf(\Cartalyst\Sentinel\Roles\EloquentRole::class, $role);
    }

    public function testUpdateRolesException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\RolesException');

        $data = [
          'name' => 'Registered2',
          'slug' => 'registered',
        ];

        $this->role->update(2, $data);
    }

    public function testUpdateFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $data = [
          'name' => 'Registered 2',
          'slug' => 'registered space',
        ];

        $this->role->update(1, $data);
    }

    public function testDelete()
    {
        $delete = $this->role->delete(1);

        $this->assertTrue($delete);
    }

    public function testDeleteRolesException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\RolesException');

        $this->role->delete(2);
    }
}