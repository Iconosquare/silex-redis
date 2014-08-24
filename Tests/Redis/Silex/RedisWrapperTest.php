<?php

namespace Redis\Silex;

class RedisWrapperTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Redis\Silex\RedisWrapper
     */
    protected $object;

    /**
     * setup
     */
    public function setUp()
    {
        $servers = array(
            array('host' => '127.0.0.1', 'port' => '6379', 'timeout' => 0.5, 'alias' => 'master', 'isMaster' => true)
        );

        $this->object = new RedisWrapper($servers);
    }

}
