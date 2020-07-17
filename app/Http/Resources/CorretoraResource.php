<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\JsonResource;


class CorretoraResource extends Resource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'corretora';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'nome'              => $this->nome,
            'created_at'             => $this->created_at,
            'updated_at'       => $this->updated_at,
            'deleted_at'              => $this->deleted_at,
            'user' => [
                'nome'  => $this->author->nome,
                'email'       => $this->author->email,
            ]
        ];
    }

    /**
     * Create new resource collection.
     *
     * @param  mixed  $resource
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        $collection = parent::collection($resource)->collection;
        $wrap = Str::plural(self::$wrap);
        return [
            $wrap           => $collection,
            $wrap . 'Count' => $collection->count()
        ];
    }
}
