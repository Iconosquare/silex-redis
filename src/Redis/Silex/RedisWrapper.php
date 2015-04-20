<?php

namespace Redis\Silex;

/**
 *   RedisWrapper
 *   @author Pierre Marseille <pierre@statigr.am>
 */
class RedisWrapper
{
    /**
     * @var array
     */
    protected $servers;

    /**
     * @var string
     */
    protected $masterAlias;

    /**
     * @var bool
     */
    protected $connected = false;

    /**
     * @var \Credis_Cluster
     */
    protected $cluster;


    /**
     * @param $servers
     */
    public function __construct($servers)
    {
        $this->servers = $servers;
    }

    /**
     * Création du cluster
     */
    private function connect()
    {
        // Reconnexion si master déco
        if ($this->connected && $this->cluster instanceof \Credis_Cluster
            && !$this->cluster->client($this->masterAlias)->isConnected()) {
            $this->cluster->client($this->masterAlias)->connect();
        }

        if (!$this->connected) {
            try {
                $servers = array();
                foreach ($this->servers as $server) {
                    $servers[] = array(
                        'host' => $server['host'],
                        'port' => $server['port'],
                        'timeout' => $server['timeout'],
                        'alias' => $server['alias'],
                        'master' => $server['isMaster']
                    );

                    if ($server['isMaster']) {
                        $this->masterAlias = $server['alias'];
                    }
                }
                $this->cluster = new \Credis_Cluster($servers);
                $this->connected = true;

                // Set the max_retry options
                foreach ($this->cluster->clients() as $index => $client) {
                    if (isset($this->servers[$index]['max_retries'])) {
                        $client->setMaxConnectRetries($this->servers[$index]['max_retries']);
                    }
                }
            } catch (\Exception $e) {
                // Erreur connexion redis
            }
        }
    }

    /**
     * @return \Credis_Cluster
     */
    public function getCluster()
    {
        $this->connect();
        return $this->cluster;
    }

    /**
     * Modifie les serveurs et reconnecte redis
     * @param $servers
     * @return \Credis_Cluster
     */
    public function setServers($servers)
    {
        $this->servers = $servers;
        $this->connected = false;
        $this->connect();
        return $this->getCluster();
    }
}
