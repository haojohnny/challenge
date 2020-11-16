<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/10/23 17:46
// | Remark:
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
     * 跟进openid获取用户信息
     * @param $openId
     * @return mixed | WeChatUser::class | null
     */
    public function getByOpenId($openId)
    {
        return $this->weChatUser->where('openid', $openId)->first();
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
        int $gender = Gender::Unknown,
        string $unionId = null,
        string $nation = null,
        string $mobile = null,
        int $isRobot = Status::No
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
