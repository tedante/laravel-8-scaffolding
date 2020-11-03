<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Hashids\Hashids;

class BaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $hashids = new Hashids(config('app.hash-code'), config('app.hash-length')); // all lowercase

        $response['id'] = $hashids->encode($this->id);

        foreach($this->getAttributes() as $key => $value ) {
            if($key != 'id') $response[$key] = $value;
        }
        
        return $response;
    }
}
