Redis provider for silex
===========

[![Build Status](https://travis-ci.org/goabonga/silex-redis.svg)](https://travis-ci.org/goabonga/silex-redis)

Set config variables
===================

```php
// Redis
$app['redis.servers'] = [
    [
        'host' => '127.0.0.1',
        'port' => '6379',
        'timeout' => 0.5,
        'alias' => 'master',
        'isMaster' => true,
        'max_retries' => 5
    ]
];
```

### Params
host - the redis host, pretty obvious <br/>
port - redis port on the server <br/>
timeout - the delay waiting response (seconds) <br/>
alias - server alias in the cluster <br/>
isMaster - set the redis master server for clustering <br/>
max_retries (optional) - set the max retry after connection failure


Register the redis wrapper
=========================

````php
// Redis
$app->register(new Redis\Silex\RedisServiceProvider());
````

Do some redis
=============

```php
$app['redis']->hmget($key, [$hashkey]);
```
