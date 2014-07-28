<?php

namespace Redis\Silex;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Redis\Silex\RedisWrapper;

/**
 *   RedisServiceProvider
 *   @author Pierre Marseille <pierre@statigr.am>
 */
class RedisServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Application $app)
    {
        $app['redisWrapper'] = $app->share(function () use ($app) {
            return new RedisWrapper($app['redis.servers']);
        });

        $app['redis'] = $app->share(function () use ($app) {
            return $app['redisWrapper']->getCluster();
        });
    }

    /**
     * {@inheritDoc}
     */
    // @codeCoverageIgnoreStart
    public function boot(Application $app)
    {
    }
    // @codeCoverageIgnoreEnd
}