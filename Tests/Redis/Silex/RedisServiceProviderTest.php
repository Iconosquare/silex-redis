<?php

namespace Redis\Silex;

use Silex\Application;

class RedisServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Silex\Application
     */
    protected $app;

    /**
     * setup
     */
    public function setUp()
    {
        $this->app = new Application();

        $this->app->register(new \Redis\Silex\RedisServiceProvider());

    }

}
