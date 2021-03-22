<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ads extends Model
{
    use SoftDeletes;

    protected $table = 'ads';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $appends = ['is_favorite'];
//    protected $casts = [
//        'is_favorite' => 'boolean'
//    ];

    protected $fillable = [
        'adsName',
        'adsDescription',
        'subCategoryId',
        'brand',
        'adsPriceType',
        'adsPrice',
        'adsCostType',
        'adsCost',
        'payment',
        'swap',
        'location',
        'original_price',
        'reserved_user_id',
        'adsStatus',
    ];

    public function scopeAvailableForSale($query)
    {
        return $query->where('adsStatus', '!=', 'sold')->whereDate('expired_at', '>=', now());
    }

    public function adsPriceWithType()
    {
        $return = '-';
        if ($this->adsPrice != null) {

            if (in_array($this->adsPriceType, ['USD', 'EUR', 'GBP'])) {
                // Get session currency
                switch (session()->get('currency', 'default')) {
                    case 'EUR':
                        if ($this->adsPriceType == 'USD') {
                            $adsPrice = $this->adsPrice / floatval(Option::getSetting('opt_exchange_eur_usd'));
                        } elseif ($this->adsPriceType == 'GBP') {
                            $adsPrice = $this->adsPrice / floatval(Option::getSetting('opt_exchange_eur_gbp'));
                        } elseif ($this->adsPriceType == 'EUR') {
                            $adsPrice = $this->adsPrice;
                        }
                        $return = '€' . sprintf('%.2n', $adsPrice);
                        break;
                    case 'USD':
                        if ($this->adsPriceType == 'USD') {
                            $adsPrice = $this->adsPrice;
                        } elseif ($this->adsPriceType == 'GBP') {
                            $adsPrice = $this->adsPrice * floatval(Option::getSetting('opt_exchange_eur_usd')) / floatval(Option::getSetting('opt_exchange_eur_gbp'));
                        } elseif ($this->adsPriceType == 'EUR') {
                            $adsPrice = $this->adsPrice * floatval(Option::getSetting('opt_exchange_eur_usd'));
                        }
                        $return = '$' . sprintf('%.2n', $adsPrice);
                        break;
                    case 'GBP':
                        if ($this->adsPriceType == 'USD') {
                            $adsPrice = $this->adsPrice * floatval(Option::getSetting('opt_exchange_eur_gbp')) / floatval(Option::getSetting('opt_exchange_eur_usd'));
                        } elseif ($this->adsPriceType == 'GBP') {
                            $adsPrice = $this->adsPrice;
                        } elseif ($this->adsPriceType == 'EUR') {
                            $adsPrice = $this->adsPrice * floatval(Option::getSetting('opt_exchange_eur_gbp'));
                        }
                        $return = '£' . sprintf('%.2n', $adsPrice);
                        break;
                    default:
//						$adsPrice = sprintf('%.2n', $this->adsPrice);
                        $adsPrice = $this->adsPrice;
//						dd($this->adsPrice);
                        switch ($this->adsPriceType) {
                            case 'EUR':
                                $return = '€' . $adsPrice;
                                break;
                            case 'GBP':
                                $return = '£' . $adsPrice;
                                break;
                            case 'USD':
                                $return = '$' . $adsPrice;
                                break;
                            // case 'CAD':
                            // 	$return = 'C$'.$adsPrice;
                            // 	break;
                            default:
                                $return = $this->adsPriceType . ' ' . $adsPrice;
                        }
                }
            } else {
                $return = $this->adsPriceType . ' ' . $this->adsPrice;
            }
        }

        return $return;
    }

    public function getAdsPriceAttribute($value)
    {
        return round($value, 1);
    }

    public function getCityRegionCountry()
    {
        return $this->adsCity . ', ' . $this->adsRegion . ', ' . $this->adsCountry;
    }

    public function UserAds()
    {
        return $this->belongsTo('App\User', 'userId');
    }

    public function Wishlists()
    {
        return $this->belongsTo('App\Wishlist', 'adsId');
    }

    public function getAdsDatasFormField($adsId)
    {
        return DB::table('ads')
            ->join('ads_datas', 'ads_datas.adsId', '=', 'ads.id')
            ->join('form_fields', 'form_fields.id', 'ads_datas.formFieldId')
            ->where('ads_datas.adsId', $adsId)
            ->whereNull('ads.deleted_at')
            ->whereNull('ads_datas.deleted_at')
            ->whereNull('form_fields.deleted_at')
            ->orderBy('form_fields.sort', 'desc')
            ->orderBy('form_fields.fieldTitle', 'asc')
            ->get();
    }

    public function getBasePackage()
    {
        return $this->hasOne("App\PackageTransaction", "adsId", "id")
            ->whereIn("packageType", ["basic", "spotlight", "auto-bump"])
            ->first();
    }

    public function images()
    {
        return $this->hasMany("App\AdsImages", "adsId", "id");
    }

    public function tag()
    {
        return $this->hasMany("App\Tag", "adsId", "id");
    }

    public function subcategory()
    {
        return $this->belongsTo("App\SubCategory", "subCategoryId");
    }

    public function breadcrumb()
    {
        return $this->hasMany("App\Breadcrumb", "adsId", "id");
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function getIsFavoriteAttribute()
    {
        return ($this->favorites->where('user_id', auth()->user()->id)->count()) > 0;
    }

    public function activities()
    {
        return $this->hasMany("App\Activity");
    }

    public function details()
    {
        return $this->hasMany("App\Ads", "parent_id", "id");
    }

    public function parent()
    {
        return $this->hasOne("App\Ads", "id", "parent_id");
    }

    public function colors()
    {
        return $this->belongsToMany(
            Color::class,
            'ads_color',
            'ads_id',
            'color_id'
        );
    }

    public function sizes()
    {
        return $this->belongsToMany(
            Size::class,
            'ads_size',
            'ads_id',
            'size_id'
        );
    }

    public function conditions()
    {
        return $this->belongsToMany(
            Condition::class,
            'ads_condition',
            'ads_id',
            'condition_id'
        );
    }

    public function filters()
    {
        return $this->belongsToMany(
            Filter::class,
            'ads_filter',
            'ads_id',
            'filter_id'
        );
    }

    public function add($data)
    {
        $this->fill($data);
        $this->userId    = Auth::id();
        $this->adsStatus = 'payed';
        $this->save();

        if (isset($data["adsImages"])) {
            $images = explode(',', $data["adsImages"]);
            foreach ($images as $image) {
                $imageName = explode('/', $image);
                array_push($imageName, 'thumb_' . array_pop($imageName));
                $imageThumb = implode('/', $imageName);

                $this->images()->create([
                    'imagePath'       => $image,
                    'imagePath_thumb' => $imageThumb,
                    'cover'           => 1
                ]);
            }
        }

        if (isset($data["filters"])) {
            $filters = [];
            foreach ($data["filters"] as $filter) {
                if ($filter !== null) {
                    if (is_array($filter)) {
                        foreach ($filter as $item) {
                            $adsFilter = Filter::find($item);
                            if (!$adsFilter->children()->get()->count() > 0) {
                                $filters[] = $item;
                            }
                        }
                    } else {
                        $adsFilter = Filter::find($filter);
                        if ($adsFilter->subCategory()->get()->isEmpty()) {
                            $filters[] = $filter;
                        }
                    }
                }
            }

            if (isset($data["otherBrand"])) {
                $otherBrand = Filter::addFilter($data["otherBrand"]);
                $filters[]  = "$otherBrand->id";
            }

            $this->filters()->sync($filters);
        } else {
            $this->filters()->detach();
        }

        $this->expired_at = $this->created_at->addDays(
            intval(\App\Option::getSetting("opt_expired_date")) != null
                ? intval(\App\Option::getSetting("opt_expired_date"))
                : 30
        );
        $this->save();
    }

    public function productTypeSymbol()
    {
        switch ($this->adsPriceType) {
            case "EUR":
                return "€";
            case "USD":
                return "$";
            case "GBP":
                return "£";
        }
    }

    public function checkThisUser()
    {
        return auth()->check() && auth()->user()->id == $this->UserAds->id;
    }

    public static function brandsPull()
    {
        return Ads::where('parent_id', '=', null)
            ->where('adsStatus', '=', 'payed')->get(['brand'])->unique('brand')->pluck('brand');
    }

    public static function prices()
    {
        $prices = [];

        $price_min = (int)Ads::min('adsPrice');
        $price_max = (int)Ads::max('adsPrice');

        $step = ceil(($price_max / 4) / 10) * 10;

        $min = $price_min;
        $max = $price_min + $step;

        for ($i = 1; $i <= 4; $i++) {
            $prices[] = [
                'min' => (int)$min,
                'max' => (int)$max,
            ];

            $min = $max;
            $max = $max + $step;
        }

        return $prices;
    }

    public function userViews()
    {
        return $this->hasMany(AdsView::class, 'adsId');
    }

    public function getUserViews()
    {
        return AdsView::where('adsId', $this->id)->count();
    }

    public function addUserView($ip)
    {
        $checkNullAdsView = AdsView::where('adsId', $this->id)
            ->where('ipAddress', $ip)
            ->where('viewAfter', 'true')
            ->get();

        $currentAdsViewId = AdsView::where('adsId', $this->id)
            ->where('ipAddress', $ip)
            ->where('viewAfter', 'true')
            ->value('id');

        if (count($checkNullAdsView) < 1) {
            $adsView            = new AdsView;
            $adsView->adsId     = $this->id;
            $adsView->ipAddress = $ip;
            $adsView->viewAfter = 'true';
            $adsView->save();
        } else if (count($checkNullAdsView) > 0) {
            $today = date("Y-m-d H:i:s", strtotime('-1 days'));

            $adsViewCreatedAt = AdsView::where('adsId', $this->id)
                ->where('ipAddress', $ip)
                ->where('created_at', '>=', $today)
                ->get();

            if (count($adsViewCreatedAt) <= 0) {
                $currentAdsView            = AdsView::find($currentAdsViewId);
                $currentAdsView->viewAfter = "false";
                $currentAdsView->save();

                $adsView            = new AdsView;
                $adsView->adsId     = $this->id;
                $adsView->ipAddress = $ip;
                $adsView->viewAfter = 'true';
                $adsView->save();
            }
        }
    }
}
