<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class DefaultCollection extends ResourceCollection
{
    /**
     * The resource class used in this collection.
     *
     * @var \Illuminate\Support\Collection
     */
    public $resourceClass;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resourceClass
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resourceClass, $resource)
    {
        parent::__construct($resource);

        $this->resourceClass = $resourceClass;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $content = [
            'data' => $this->resourceClass::collection($this->collection),
        ];

        $pagination = request('pagination', true);
        if (
            $this->resource instanceof LengthAwarePaginator &&
            filter_var($pagination, FILTER_VALIDATE_BOOLEAN)
        ) {
            $content['pagination'] = [
                'total' => (int) $this->total(),
                'current_page' => (int) $this->currentPage(),
                'first_page' => 1,
                'prev_page' => $this->currentPage() > 1 ? $this->currentPage() - 1 : null,
                'next_page' => $this->hasMorePages() ? $this->currentPage() + 1 : null,
                'last_page' => (int) $this->lastPage(),
                'per_page' => (int) $this->perPage(),
                'is_last_page' => !$this->hasMorePages(),
            ];
        } else {
            $content['total'] = $this->collection->count();
        }

        return $content;
    }

    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent(), true);
        unset($jsonResponse['links'], $jsonResponse['meta']);
        $response->setContent(json_encode($jsonResponse));
    }
}
