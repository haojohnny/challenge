<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WeChatUser
 * @package App\Models
 *
 * @property int $id
 * @property string $openid
 * @property string $union_id
 * @property string $nickname
 * @property int $gender
 * @property string $avatar
 * @property string $country
 * @property string $city
 * @property string $language
 * @property string $nation
 * @property string $mobile
 * @property int $is_robot
 */
class WeChatUser extends Model
{
    use HasFactory;

    protected $table = 'wechat_user';

    /**
     * 是否主动维护时间戳
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 可批量赋值属性
     *
     * @var array
     */
    protected $fillable = [
        'openid', 'union_id', 'nickname', 'gender', 'avatar', 'country', 'city', 'language', 'nation', 'mobile', 'isRobot'
    ];
}
