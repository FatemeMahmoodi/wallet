<?php

namespace App\Http\Resources\User;


use App\Http\Resources\Package\PackageResource;
use App\Http\Resources\Panel\PanelResource;
use App\Http\Resources\System\File\FileCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'panel' =>  new PanelResource($this->panel),
            'package'=>  new PackageResource($this->package),
            'documents' => new FileCollection($this->documents)
        ];
             return array_merge(parent::toArray($request) , $data);
    }
}
