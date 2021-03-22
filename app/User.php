<?php

namespace App;

use App\Events\NewNotification;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class User extends Authenticatable
{
    use Notifiable;

//	use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->Ads) {
                $user->Ads()->delete();
            }

            if ($user->blockedUsers) {
                $user->blockedUsers()->delete();
            }
            if ($user->buyer_activities) {
                $user->buyer_activities()->delete();
            }
            if ($user->followers) {
                $user->followers()->delete();
            }
        });
    }

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'fullName', 'avatar', 'email', 'password', 'userRole', 'isRetailer', 'subscription', 'gender', 'country', 'city',
        'delivery', 'receiving_money', 'about_me', 'instagram_link', 'facebook_link', 'show_email', 'isSocial'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAvatarAttribute($value)
    {
        return !empty($value) ? $value : '/newthemplate/admin/img/empty_user_img.png';
    }

    public function Ads()
    {
        return $this->hasMany('App\Ads', 'userId');
    }

    public function getDraftAdsCount()
    {
        return $this->hasMany('App\Ads', 'userId')->where("adsPlaceMethod", "=", "draft")->where("adsStatus", "!=", "unavailable")->count();
    }

    public function getUnreadMsgCount()
    {
        return $this->hasMany('App\Chat', 'userId', "id")->where("seen", "=", "0")->count();
    }

    public function getCityRegionCountry()
    {
        return $this->city . ', ' . $this->region . ', ' . $this->country;
    }

    public function favoriteAds()
    {
        return $this->belongsToMany('App\Ads', 'favorites', 'user_id', 'favoritable_id');
    }

    public function agreements()
    {
        return $this->hasMany('App\PayPalAgreements', 'uid', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'userId');
    }

    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_user_id');
    }

    public function buyer_activities()
    {
        return $this->hasMany(Activity::class, 'buyer_id', 'id');
    }

    public function getOnlineAttribute()
    {
        $created_date = Carbon::parse($this->last_login);

        if ($created_date->isToday()) {
            $diff_hours = Carbon::now()->diffInHours($created_date);

            if ($diff_hours < 1) {
                return 'Online';
            } else {
                return $diff_hours . ' hours ago';
            }
        } else {
            return 'Offline';
        }
    }

    public function isOnline()
    {
        if ($this->last_login != null) {
            if ((strtotime("now") - strtotime($this->last_login)) < 300) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getCountryCode()
    {
        // return $this->country;
        $countryList = array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas the',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island (Bouvetoya)',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros the',
            'CD' => 'Congo',
            'CG' => 'Congo the',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote d\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'CZ' => 'Czechia',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FO' => 'Faroe Islands',
            'FK' => 'Falkland Islands (Malvinas)',
            'FJ' => 'Fiji the Fiji Islands',
            'FI' => 'Finland',
            'FR' => 'France, French Republic',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia the',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KP' => 'Korea',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyz Republic',
            'LA' => 'Lao',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'AN' => 'Netherlands Antilles',
            'NL' => 'Netherlands the',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn Islands',
            'PL' => 'Poland',
            'PT' => 'Portugal, Portuguese Republic',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia (Slovak Republic)',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia, Somali Republic',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard & Jan Mayen Islands',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland, Swiss Confederation',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States of America',
            'UM' => 'United States Minor Outlying Islands',
            'VI' => 'United States Virgin Islands',
            'UY' => 'Uruguay, Eastern Republic of',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        );
        return strtolower(array_search($this->country, $countryList));
    }

    public function followers()
    {
        return $this->hasMany('App\SavedUsers', 'userId');
    }

    public function saveNotification($message, $picture = null)
    {
        $notifications = $this->getNotifications();

        $id = collect($notifications)->max('id') + 1;

        $notifications[] = [
            'id'      => $id,
            'message' => $message,
            'picture' => $picture,
            'date'    => Carbon::now(),
            'read'    => 0,
        ];

        Cache::put('user:' . $this->id . ':notifications', $notifications, 60 * 48);

        $this->sendNotification($message, $id, $picture);
    }

    public function sendNotification($message, $id = null, $picture = null)
    {
        event(new NewNotification($this, $message, $id, $picture));
    }

    public function getNotifications()
    {
        $notifications = Cache::get('user:' . $this->id . ':notifications');

        if ($notifications == null) {
            $notifications = [];
        }

        return $notifications;
    }

    public function getNewNotifications()
    {
        $notifications = $this->getNotifications();

        if (empty($notifications)) {
            return [];
        }

        return collect($notifications)->where('read', 0)->all();
    }

    public function deleteNotification($id)
    {
        $notifications = $this->getNotifications();

        foreach ($notifications as $key => $notification) {
            if ($notification['id'] == $id) {
                unset($notifications[$key]);
            }
        }

        Cache::put('user:' . $this->id . ':notifications', $notifications, 60 * 48);
    }

    public function readNotifications($ids)
    {
        $notifications = $this->getNotifications();

        foreach ($notifications as $key => $notification) {
            if (array_search($notification['id'], $ids) !== false) {
                $notification['read'] = 1;
                $notifications[$key]  = $notification;
            }
        }

        Cache::put('user:' . $this->id . ':notifications', $notifications, 60 * 48);
    }

    public function getTransactionsWalletSumAttribute()
    {
        $user = auth()->user();

        $paymentSum = $user->transactions()->where('type', 'payment')->sum('total');
        $payoutSum  = $user->transactions()->where('type', 'payout')->where('status', '!=', 'canceled')->sum('total');

        return (int)($paymentSum - $payoutSum);
    }

    public function getActivity($type)
    {
        switch ($type) {
            case 'buyer':
                return round(
                    Activity::where('buyer_id', $this->id)
                        ->whereNotNull('seller_mark')
                        ->where('status', '=', 'success')
                        ->get()
                        ->pluck('seller_mark')
                        ->avg()
                );
            case 'seller':
                return round(
                    Activity::where('seller_id', $this->id)
                        ->whereNotNull('buyer_mark')
                        ->where('status', '=', 'success')
                        ->get()
                        ->pluck('buyer_mark')
                        ->avg()
                );
            default:
                return 0;
        }
    }
}
