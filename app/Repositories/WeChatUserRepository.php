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
     * @param $openId
     * @return mixed | WeChatUser::class | null
     */
    public function getByOpenId($openId)
    {
        return $this->weChatUser->where('openid', $openId)->first();
    }

    /**
     * @param $openid
     * @param $nickname
     * @param $avatar
     * @param $country
     * @param $city
     * @param $language
     * @param int $gender
     * @param null $nation
     * @param null $mobile
     * @param int $isRobot
     *
     * @return mixed | weChatUser::class
     */
    public function create(
        $openid,
        $nickname,
        $avatar,
        $country,
        $city,
        $language,
        $gender = Gender::Unknown,
        $unionId = null,
        $nation = null,
        $mobile = null,
        $isRobot = Status::No
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
