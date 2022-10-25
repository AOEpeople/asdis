<?php

namespace Aoe\Asdis\Api;

use Aoe\Asdis\Api\Exception\NotEnabledException;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\Factory as AlgorithmFactory;
use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection as ServerCollection;
use Aoe\Asdis\Domain\Model\Server\Factory as ServerFactory;
use Aoe\Asdis\Domain\Repository\ServerRepository;
use Aoe\Asdis\System\Configuration\Exception\TypoScriptSettingNotExists;
use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Uri\Normalizer;

class Url
{
    /**
     * @var AlgorithmFactory
     */
    private $distributionAlgorithmFactory;

    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @var Provider
     */
    private $configurationProvider;

    /**
     * @var Normalizer
     */
    private $uriNormalizer;

    /**
     * @var Page
     */
    private $page;

    /**
     * @var ServerFactory
     */
    private $serverFactory;

    /**
     * @param AlgorithmFactory $distributionAlgorithmFactory
     * @param ServerRepository $serverRepository
     * @param Provider $configurationProvider
     * @param Normalizer $uriNormalizer
     * @param Page $page
     * @param ServerFactory $serverFactory
     */
    public function __construct(
        AlgorithmFactory $distributionAlgorithmFactory,
        ServerRepository $serverRepository,
        Provider $configurationProvider,
        Normalizer $uriNormalizer,
        Page $page,
        ServerFactory $serverFactory
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

        $asset = new Asset();
        $asset->setOriginalPath($path);
        $asset->setNormalizedPath($this->uriNormalizer->normalizePath($path));

        $this->distributeAsset($asset);

        return $asset->getUri();
    }

    /**
     * @param Asset $asset
     * @throws NotEnabledException
     */
    private function distributeAsset(Asset $asset)
    {
        try {
            if ($this->configurationProvider->isReplacementEnabled()) {
                $collection = new AssetCollection();
                $collection->append($asset);
                $distributionAlgorithm = $this->distributionAlgorithmFactory
                    ->buildDistributionAlgorithmFromKey($this->configurationProvider->getDistributionAlgorithmKey());
                $distributionAlgorithm->distribute($collection, $this->getServers());
            } else {
                throw new NotEnabledException(1452171538);
            }
        } catch (TypoScriptSettingNotExists $e) {
            throw new NotEnabledException(1452171530, $e);
        }
    }

    /**
     * @return ServerCollection
     */
    private function getServers()
    {
        $servers = $this->serverRepository->findAllByPage($this->page);
        $this->forceSSL($servers);
        return $servers;
    }

    /**
     * @param ServerCollection $servers
     */
    private function forceSSL(ServerCollection $servers)
    {
        foreach ($servers as $server) {
            /** @var Server $server */
            $server->setProtocol(Server::PROTOCOL_HTTPS);
        }
        $servers->rewind();
    }
}
