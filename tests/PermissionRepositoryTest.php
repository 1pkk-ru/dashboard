<?php

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

        $this->permissionRepository->create($permissionData, false);
    }

    public function testGetAll()
    {
        $permissions = $this->permissionRepository->getAll();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $permissions);
    }

    public function testGetById()
    {
        $permission = $this->permissionRepository->getById(1);

        $this->assertInstanceOf(\Odotmedia\Dashboard\Models\Permission::class, $permission);
    }

    public function testGetByIdNull()
    {
        $permission = $this->permissionRepository->getById(2);

        $this->assertNull($permission);
    }

    public function testCreate()
    {
        $data = [
          'name' => 'Registered',
          'slug' => 'registered',
        ];

        $permission = $this->permissionRepository->create($data, false);

        $this->assertInstanceOf(\Odotmedia\Dashboard\Models\Permission::class, $permission);
    }

    public function testCreateFormValidationException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\FormValidationException');

        $data = [
          'name' => 'Administrator (Full Access)',
          'slug' => 'admin',
        ];

        $this->permissionRepository->create($data);
    }

    public function testCreatePermissionsException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\PermissionsException');

        $data = [
          'name' => 'Administrator (Full Access)',
          'slug' => 'admin',
        ];

        $this->permissionRepository->create($data, false);
    }

    public function testUpdate()
    {
        $data = [
            'name' => 'Administrator',
            'slug' => 'admin',
        ];

        $permission = $this->permissionRepository->update($data, 1, false);

        $this->assertInstanceOf(\Odotmedia\Dashboard\Models\Permission::class, $permission);
    }

    public function testUpdatePermissionsException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\PermissionsException');

        $data = [
          'name' => 'Administrator',
          'slug' => 'admin',
        ];

        $this->permissionRepository->update($data, 2, false);
    }

    public function testUpdateFormValidationException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\FormValidationException');

        $data = [
            'name' => 'Administrator',
            'slug' => 'no spaces',
        ];

        $this->permissionRepository->update($data, 1);
    }

    public function testDelete()
    {
        $delete = $this->permissionRepository->delete(1);

        $this->assertTrue($delete);
    }

    public function testDeletePermissionsException()
    {
        $this->setExpectedException('Odotmedia\Dashboard\Exceptions\PermissionsException');

        $this->permissionRepository->delete(2);
    }
}