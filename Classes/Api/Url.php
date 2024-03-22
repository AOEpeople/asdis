<?php

namespace Aoe\Asdis\Api;

use Aoe\Asdis\Api\Exception\NotEnabledException;
use Aoe\Asdis\Domain\Model\Asset;
use Aoe\Asdis\Domain\Model\Asset\Collection as AssetCollection;
use Aoe\Asdis\Domain\Model\DistributionAlgorithm\Factory;
use Aoe\Asdis\Domain\Model\Page;
use Aoe\Asdis\Domain\Model\Server;
use Aoe\Asdis\Domain\Model\Server\Collection as ServerCollection;
use Aoe\Asdis\Domain\Repository\ServerRepository;
use Aoe\Asdis\System\Configuration\Exception\TypoScriptSettingNotExists;
use Aoe\Asdis\System\Configuration\Provider;
use Aoe\Asdis\System\Uri\Normalizer;

class Url
{
    private Factory $distributionAlgorithmFactory;

    private ServerRepository $serverRepository;

    private Provider $configurationProvider;

    private Normalizer $uriNormalizer;

    private Page $page;

    public function __construct(
        Factory $distributionAlgorithmFactory,
        ServerRepository $serverRepository,
        Provider $configurationProvider,
        Normalizer $uriNormalizer,
        Page $page
    ) {
        $this->distributionAlgorithmFactory = $distributionAlgorithmFactory;
        $this->serverRepository = $serverRepository;
        $this->configurationProvider = $configurationProvider;
        $this->uriNormalizer = $uriNormalizer;
        $this->page = $page;
    }

    public function getDistributedUrlForPath(string $path): ?string
    {
        if ($path === '' || $path === '0') {
            return null;
        }

        $asset = new Asset();
        $asset->setOriginalPath($path);
        $asset->setNormalizedPath($this->uriNormalizer->normalizePath($path));

        $this->distributeAsset($asset);

        return $asset->getUri();
    }

    private function distributeAsset(Asset $asset): void
    {
        try {
            if ($this->configurationProvider->isReplacementEnabled()) {
                $collection = new AssetCollection();
                $collection->append($asset);
                $distributionAlgorithm = $this->distributionAlgorithmFactory
                    ->buildDistributionAlgorithmFromKey($this->configurationProvider->getDistributionAlgorithmKey());
                $distributionAlgorithm->distribute($collection, $this->getServers());
            } else {
                throw new NotEnabledException(1_452_171_538);
            }
        } catch (TypoScriptSettingNotExists $typoScriptSettingNotExists) {
            throw new NotEnabledException(1_452_171_530, $typoScriptSettingNotExists);
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

    private function forceSSL(ServerCollection $servers): void
    {
        foreach ($servers as $server) {
            /** @var Server $server */
            $server->setProtocol(Server::PROTOCOL_HTTPS);
        }

        $servers->rewind();
    }
}
