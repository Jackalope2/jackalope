<?php

namespace Jackalope2;

class RepositoryFactory implements RepositoryFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function getRepository(array $parameters = null)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function getConfigurationKeys()
    {
        return array(
            'storage' => 'Storage backend to use',
        );
    }
}
