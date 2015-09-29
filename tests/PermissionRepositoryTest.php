<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

class PermissionRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->setupData();
    }

    protected function setupData()
    {
        $permissionData = [
          'name' => 'Administrator (Full Access)',
          'slug' => 'admin',
        ];

        $this->permission->create($permissionData);
    }

    public function testAll()
    {
        $permissions = $this->permission->all();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $permissions);
    }

    public function testFind()
    {
        $permission = $this->permission->find(1);

        $this->assertInstanceOf(\Laraflock\Dashboard\Models\Permission::class, $permission);
    }

    public function testFindNull()
    {
        $permission = $this->permission->find(2);

        $this->assertNull($permission);
    }

    public function testCreate()
    {
        $data = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $permission = $this->permission->create($data);

        $this->assertInstanceOf(\Laraflock\Dashboard\Models\Permission::class, $permission);
    }

    public function testCreateFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $data = [
          'name' => 'Administrator (Full Access)',
          'slug' => 'admin',
        ];

        $this->permission->create($data);
    }

    public function testUpdate()
    {
        $data = [
            'name' => 'Administrator',
            'slug' => 'admin',
        ];

        $permission = $this->permission->update(1, $data);

        $this->assertInstanceOf(\Laraflock\Dashboard\Models\Permission::class, $permission);
    }

    public function testUpdatePermissionsException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\PermissionsException');

        $data = [
          'name' => 'Administrator',
          'slug' => 'admin',
        ];

        $this->permission->update(2, $data);
    }

    public function testUpdateFormValidationException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\FormValidationException');

        $data = [
            'name' => 'Administrator',
            'slug' => 'no spaces',
        ];

        $this->permission->update(1, $data);
    }

    public function testDelete()
    {
        $delete = $this->permission->delete(1);

        $this->assertTrue($delete);
    }

    public function testDeletePermissionsException()
    {
        $this->setExpectedException('Laraflock\Dashboard\Exceptions\PermissionsException');

        $this->permission->delete(2);
    }
}