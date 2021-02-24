<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $parent = parent::toArray($request);

        $dataBooks['books'] = $this->books()->paginate(6);
        $dataMerge = array_merge($parent, $dataBooks);
        return [
            'status' => 'success',
            'message' => 'data category',
            'data' => $dataMerge
        ];
    }
}
