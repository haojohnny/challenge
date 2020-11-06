<?php

namespace App\Http\Resources\WeChat;

use App\Enums\ErrorCode;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nickname' => $this->nickname,
            'gender' => $this->gender,
            'avatar' => $this->avatar,
            'country' => $this->country,
            'city' => $this->city,
            'language' => $this->language,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    /**
     * 返回应该和资源一起返回的其他数据数组
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'code' => ErrorCode::Success,
            'msg' => 'success'
        ];
    }
}
