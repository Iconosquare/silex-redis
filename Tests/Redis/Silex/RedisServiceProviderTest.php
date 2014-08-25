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

    /**
     * test register
     */
    public function testRegister()
    {
        $this->app['redis.servers'] = array(
            array('host' => '127.0.0.1', 'port' => '6379', 'timeout' => 0.5, 'alias' => 'master', 'isMaster' => true)
        );

        $this->assertArrayHasKey('host',$this->app['redis.servers'][0]);
        $this->assertArrayHasKey('port',$this->app['redis.servers'][0]);
        $this->assertArrayHasKey('timeout',$this->app['redis.servers'][0]);
        $this->assertArrayHasKey('alias',$this->app['redis.servers'][0]);
        $this->assertArrayHasKey('isMaster',$this->app['redis.servers'][0]);

        $this->assertEquals(array('host' => '127.0.0.1', 'port' => '6379', 'timeout' => 0.5, 'alias' => 'master', 'isMaster' => true),$this->app['redis.servers'][0]);
        $this->assertInstanceOf('Redis\Silex\RedisWrapper',$this->app['redisWrapper']);
        $this->assertInstanceOf('Credis_Cluster',$this->app['redis']);

    }

    /**
     * test service
     */
    public function testService()
    {
        $key = 'key_name';
        $value = 'key_value';

        $this->app['redis.servers'] = array(
            array('host' => '127.0.0.1', 'port' => '6379', 'timeout' => 0.5, 'alias' => 'master', 'isMaster' => true)
        );

        $response = $this->app['redis']->set($key, $value);
        $this->assertTrue($response);
        $this->assertEquals($value, $this->app['redis']->get($key));

    }

}
