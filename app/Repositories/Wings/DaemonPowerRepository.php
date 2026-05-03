<?php

namespace Xcure\Repositories\Wings;

use Webmozart\Assert\Assert;
use Xcure\Models\Server;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\TransferException;
use Xcure\Exceptions\Http\Connection\DaemonConnectionException;

/**
 * @method \Xcure\Repositories\Wings\DaemonPowerRepository setNode(\Xcure\Models\Node $node)
 * @method \Xcure\Repositories\Wings\DaemonPowerRepository setServer(\Xcure\Models\Server $server)
 */
class DaemonPowerRepository extends DaemonRepository
{
    /**
     * Sends a power action to the server instance.
     *
     * @throws DaemonConnectionException
     */
    public function send(string $action): ResponseInterface
    {
        Assert::isInstanceOf($this->server, Server::class);

        try {
            return $this->getHttpClient()->post(
                sprintf('/api/servers/%s/power', $this->server->uuid),
                ['json' => ['action' => $action]]
            );
        } catch (TransferException $exception) {
            throw new DaemonConnectionException($exception);
        }
    }
}
