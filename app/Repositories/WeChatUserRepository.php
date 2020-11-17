<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/10/23 17:46
// | Remark:微信用户数据仓库
// |

namespace App\Repositories;

use App\Enums\Gender;
use App\Enums\Status;
use App\Models\WeChatUser;

/**
 * Class WeChatUserRepository
 * @package App\Repositories
 */
class WeChatUserRepository
{
    protected $weChatUser;

    public function __construct(WeChatUser $user)
    {
        $this->weChatUser = $user;
    }

    /**
     * 根据openid获取用户信息
     * @param $openId
     * @return mixed | WeChatUser::class | null
     */
    public function getByOpenId($openId)
    {
        return $this->weChatUser->where('openid', $openId)->first();
    }

    /**
     * 根据id获取用户信息
     * @param int $id
     * @return WeChatUser::class | null
     */
    public function getById(int $id)
    {
        return $this->weChatUser->where('id', $id)->first();
    }

    /**
     * 创建微信用户
     * @param string $openid
     * @param string $nickname
     * @param string $avatar
     * @param string $country
     * @param string $city
     * @param string $language
     * @param int $gender
     * @param string $unionId
     * @param string $nation
     * @param string $mobile
     * @param int $isRobot
     *
     * @return mixed | weChatUser::class
     */
    public function create(
        string $openid,
        string $nickname,
        string $avatar,
        string $country,
        string $city,
        string $language,
        int $gender,
        string $unionId,
        string $nation,
        string $mobile,
        int $isRobot
    ) {
        $data = [
            'openid' => $openid,
            'nickname' => $nickname,
            'avatar' => $avatar,
            'country' => $country,
            'city' => $city,
            'language' => $language,
            'gender' => $gender,
            'union_id' => $unionId,
            'nation' => $nation,
            'mobile' => $mobile,
            'is_robot' => $isRobot
        ];

        return $this->weChatUser->create($data);
    }
}
