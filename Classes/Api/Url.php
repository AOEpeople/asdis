<?php

/**
 * @package Tx_Asdis
 * @subpackage Api
 * @author Kevin Schu <kevin.schu@aoe.com>
 */
class Tx_Asdis_Api_Url
{
    /**
     * @var Tx_Asdis_Domain_Model_DistributionAlgorithm_Factory
     */
    private $distributionAlgorithmFactory;

    /**
     * @var Tx_Asdis_Domain_Repository_ServerRepository
     */
    private $serverRepository;

    /**
     * @var Tx_Asdis_System_Configuration_Provider
     */
    private $configurationProvider;

    /**
     * @var Tx_Asdis_System_Uri_Normalizer
     */
    private $uriNormalizer;

    /**
     * @var Tx_Asdis_Domain_Model_Page
     */
    private $page;

    /**
     * @var Tx_Asdis_Domain_Model_Server_Factory
     */
    private $serverFactory;

    /**
     * @param Tx_Asdis_Domain_Model_DistributionAlgorithm_Factory $distributionAlgorithmFactory
     * @param Tx_Asdis_Domain_Repository_ServerRepository $serverRepository
     * @param Tx_Asdis_System_Configuration_Provider $configurationProvider
     * @param Tx_Asdis_System_Uri_Normalizer $uriNormalizer
     * @param Tx_Asdis_Domain_Model_Page $page
     * @param Tx_Asdis_Domain_Model_Server_Factory $serverFactory
     */
    public function __construct(
        Tx_Asdis_Domain_Model_DistributionAlgorithm_Factory $distributionAlgorithmFactory,
        Tx_Asdis_Domain_Repository_ServerRepository $serverRepository,
        Tx_Asdis_System_Configuration_Provider $configurationProvider,
        Tx_Asdis_System_Uri_Normalizer $uriNormalizer,
        Tx_Asdis_Domain_Model_Page $page,
        Tx_Asdis_Domain_Model_Server_Factory $serverFactory
    ) {
        $this->distributionAlgorithmFactory = $distributionAlgorithmFactory;
        $this->serverRepository = $serverRepository;
        $this->configurationProvider = $configurationProvider;
        $this->uriNormalizer = $uriNormalizer;
        $this->page = $page;
        $this->serverFactory = $serverFactory;
    }


    /**
     * @param string $path
     * @return string
     */
    public function getDistributedUrlForPath($path)
    {
        if (empty($path)) {
            return null;
        }

        $asset = new Tx_Asdis_Domain_Model_Asset();
        $asset->setOriginalPath($path);
        $asset->setNormalizedPath($this->uriNormalizer->normalizePath($path));

        $this->distributeAsset($asset);

        return $asset->getUri();
    }

    /**
     * @param Tx_Asdis_Domain_Model_Asset $asset
     * @throws Tx_Asdis_Api_Exception_NotEnabledException
     */
    private function distributeAsset(Tx_Asdis_Domain_Model_Asset $asset)
    {
        try {
            if ($this->configurationProvider->isReplacementEnabled()) {
                $collection = new Tx_Asdis_Domain_Model_Asset_Collection();
                $collection->append($asset);
                $distributionAlgorithm = $this->distributionAlgorithmFactory
                    ->buildDistributionAlgorithmFromKey($this->configurationProvider->getDistributionAlgorithmKey());
                $distributionAlgorithm->distribute($collection, $this->getServers());
            } else {
                throw new Tx_Asdis_Api_Exception_NotEnabledException(1452171538);
            }
        } catch (Tx_Asdis_System_Configuration_Exception_TypoScriptSettingNotExists $e) {
            throw new Tx_Asdis_Api_Exception_NotEnabledException(1452171530, $e);
        }
    }

    /**
     * @return Tx_Asdis_Domain_Model_Server_Collection
     */
    private function getServers()
    {
        $servers = $this->serverRepository->findAllByPage($this->page);
        $this->forceSSL($servers);
        return $servers;
    }

    /**
     * @param Tx_Asdis_Domain_Model_Server_Collection $servers
     * @return void
     */
    private function forceSSL(Tx_Asdis_Domain_Model_Server_Collection $servers)
    {
        foreach ($servers as $server) {
            /** @var Tx_Asdis_Domain_Model_Server $server */
            $server->setProtocol(Tx_Asdis_Domain_Model_Server::PROTOCOL_HTTPS);
        }
        $servers->rewind();
    }
}
