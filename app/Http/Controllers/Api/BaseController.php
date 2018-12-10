<?php

namespace App\Http\Controllers\Api;

use App\Models\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection as LaravelCollection;
use InvalidArgumentException;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController
{
    /** @var \League\Fractal\Manager */
    protected $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param \App\Models\Model $model
     * @param \League\Fractal\TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withItem(Model $model, TransformerAbstract $transformer)
    {
        $resource = new Item($model, $transformer);

        return new JsonResponse($this->manager->createData($resource)->toArray());
    }

    /**
     * @param $collection
     * @param \League\Fractal\TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withCollection(LaravelCollection $collection, TransformerAbstract $transformer)
    {
        $resource = new Collection($collection, $transformer);

        return new JsonResponse($this->manager->createData($resource)->toArray());
    }

    /**
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
     * @param \League\Fractal\TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withPagination(LengthAwarePaginator $paginator, TransformerAbstract $transformer)
    {
        $resource = new Collection($paginator->items(), $transformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return new JsonResponse($this->manager->createData($resource)->toArray());
    }

    /**
     * @param string $message
     * @param string $errorCode
     * @param int $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withError(string $message, string $errorCode, int $status = Response::HTTP_BAD_REQUEST)
    {
        throw_if($status >= 200 && $status < 300,
            new InvalidArgumentException("2xx is reserved for success response."));

        return new JsonResponse([
            'message'    => $message,
            'error_code' => $errorCode,
        ], $status);
    }

    /**
     * @param \App\Models\Model $item
     * @param \League\Fractal\TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withCreated(Model $item, TransformerAbstract $transformer)
    {
        $response = $this->withItem($item, $transformer);
        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNoContent()
    {
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
