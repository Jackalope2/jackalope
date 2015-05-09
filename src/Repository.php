<?php

namespace Jackalope2;

use PHPCR\RepositoryInterface;
use PHPCR\LoginException;

class Repository implements RepositoryInterface
{
    private $defaultWorkspace;
    private $nodeStore;

    public function __construct(
        $defaultWorkspace = 'default',
        NodeStoreInterface $nodeStore
    )
    {
        $this->defaultWorkspace = $defaultWorkspace;
    }

    /**
     * {@inheritDoc}
     */
    public function login(CredentialsInterface $credentials = null, $workspaceName = null)
    {
        if (null === $workspaceName) {
            $workspaceName = $this->defaultWorkspace;
        }

        $this->authenticator->authenticate($credentials, $workspaceName);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescriptorKeys()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function isStandardDescriptor($key)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getDescriptor($key)
    {
    }
}
