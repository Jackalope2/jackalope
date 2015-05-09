<?php

namespace Jackalope2\Tests\Unit;

use Jackalope2\Repository;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->credentials = $this->prophesize('PHPCR\CredentialsInterface');
        $this->repository = new Repository();
    }

    /**
     * It should throw an exception if the given workspace does not exist
     * and it is not the default workspace
     *
     * @expectedException \PHPCR\NoSuchWorkspaceException
     */
    public function testThrowExceptionNotExistsAndNotDefault()
    {
        $this->markSkipped('Implement me');
        $this->repository->login($this->credentials->reveal(), 'notexisting');
    }

    /**
     * NULL workspace should be interpreted as the default workspace
     */
    public function testNullIsDefault()
    {
        $this->markSkipped('Implement me');
    }
}
