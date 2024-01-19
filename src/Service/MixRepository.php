<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Psr\Cache\CacheItemInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bridge\Twig\Command\DebugCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Description of MixRepository
 *
 * @author user
 */
class MixRepository {
    public function __construct(
        private CacheInterface $cache,
        private HttpClientInterface $githubContentClient,
        #[Autowire(service: 'twig.command.debug')]
        private DebugCommand $twigDebugCommand,
        #[Autowire('%kernel.debug%')]
        private bool $isDebug
    ) {}

    public function findAll(): array
    {
//        $output = new BufferedOutput();
//        $this->twigDebugCommand->run(new ArrayInput([]), $output);
//        dd($output);

        return $this->cache->get('mixes_data', function(CacheItemInterface $cacheItem) {
            $cacheItem->expiresAfter($this->isDebug ? 10 : 60 * 5);
            $response = $this->githubContentClient->request('GET', '/SymfonyCasts/vinyl-mixes/main/mixes.json');
            
            return $response->toArray();
        });
    }
}
