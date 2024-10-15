<?php

namespace App\Http\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MyCollection extends ResourceCollection
{
    public function __construct($resource, private string $message, private bool $success, private $extra)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'extra' => $this->extra,
            'data' => $this->collection,
            'meta' => ['count' => $this->collection->count()],
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
