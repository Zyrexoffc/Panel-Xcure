<?php

namespace Xcure\Http\Controllers\Api\Application\Servers;

use Xcure\Models\Server;
use Xcure\Services\Servers\BuildModificationService;
use Xcure\Services\Servers\DetailsModificationService;
use Xcure\Transformers\Api\Application\ServerTransformer;
use Xcure\Http\Controllers\Api\Application\ApplicationApiController;
use Xcure\Http\Requests\Api\Application\Servers\UpdateServerDetailsRequest;
use Xcure\Http\Requests\Api\Application\Servers\UpdateServerBuildConfigurationRequest;

class ServerDetailsController extends ApplicationApiController
{
    /**
     * ServerDetailsController constructor.
     */
    public function __construct(
        private BuildModificationService $buildModificationService,
        private DetailsModificationService $detailsModificationService,
    ) {
        parent::__construct();
    }

    /**
     * Update the details for a specific server.
     *
     * @throws \Xcure\Exceptions\DisplayException
     * @throws \Xcure\Exceptions\Model\DataValidationException
     * @throws \Xcure\Exceptions\Repository\RecordNotFoundException
     */
    public function details(UpdateServerDetailsRequest $request, Server $server): array
    {
        $updated = $this->detailsModificationService->returnUpdatedModel()->handle(
            $server,
            $request->validated()
        );

        return $this->fractal->item($updated)
            ->transformWith($this->getTransformer(ServerTransformer::class))
            ->toArray();
    }

    /**
     * Update the build details for a specific server.
     *
     * @throws \Xcure\Exceptions\DisplayException
     * @throws \Xcure\Exceptions\Model\DataValidationException
     * @throws \Xcure\Exceptions\Repository\RecordNotFoundException
     */
    public function build(UpdateServerBuildConfigurationRequest $request, Server $server): array
    {
        $server = $this->buildModificationService->handle($server, $request->validated());

        return $this->fractal->item($server)
            ->transformWith($this->getTransformer(ServerTransformer::class))
            ->toArray();
    }
}
