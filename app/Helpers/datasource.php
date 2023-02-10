<?php

use Illuminate\Database\Eloquent\Builder;


/**
 * @return \App\Models\Group[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
 */
function groups()
{
    return \App\Models\Group::withTrashed()->get();
}

/**
 * @return \App\Models\User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
 */
function products()
{
    return \App\Models\Product::withTrashed()->get();
}

/**
 * @return \App\Models\User[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
 */
function users()
{
    return \App\Models\User::withTrashed()->get();
}

/**
 * @return mixed
 */
function affiliates()
{
    return \App\Models\User::has('affiliate')->withTrashed()->get();
}

/**
 * @return mixed
 */
function admins()
{
    return \App\Models\User::whereHas('group', function (Builder $query) {
        $query->where('can_access_admin', 'yes');
    })->withTrashed()->get();
}

/**
 * @return \App\Models\City[]|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
 */
function cities()
{
    return \App\Models\City::withTrashed()->get();
}

/**
 * @return \App\Models\Coupon[]|Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
 */
function coupons()
{
    return \App\Models\Coupon::withTrashed()->get();
}


/**
 * @return \Illuminate\Support\Collection
 */
function trueFalseOptions()
{
    return collect([
        ['label' => trans('admin.yes'), 'value' => 1],
        ['label' => trans('admin.no'), 'value' => 0]
    ]);
}


/**
 * @return \Illuminate\Support\Collection
 */
function yesNoOptions()
{
    return collect([
        ['label' => trans('admin.yes'), 'value' => 'yes'],
        ['label' => trans('admin.no'), 'value' => 'no']
    ]);
}


/**
 * @return \Illuminate\Support\Collection
 */
function months_string()
{
    return collect([
        ['label' => trans('admin.jan'), 'value' => 1],
        ['label' => trans('admin.feb'), 'value' => 2],
        ['label' => trans('admin.mar'), 'value' => 3],
        ['label' => trans('admin.apr'), 'value' => 4],
        ['label' => trans('admin.may'), 'value' => 5],
        ['label' => trans('admin.jun'), 'value' => 6],
        ['label' => trans('admin.jul'), 'value' => 7],
        ['label' => trans('admin.aug'), 'value' => 8],
        ['label' => trans('admin.sep'), 'value' => 9],
        ['label' => trans('admin.oct'), 'value' => 10],
        ['label' => trans('admin.nov'), 'value' => 11],
        ['label' => trans('admin.dec'), 'value' => 12],
    ]);
}


/**
 * @return \Illuminate\Support\Collection
 */
function year()
{
    $yearsArray = [];
    $startYear = \Carbon\Carbon::now()->year-5;
    $endYear = $startYear+10;
    for ($i = $startYear; $i <= $endYear; $i++){
        $yearsArray[] = ['label' => $i, 'value' => $i];
    }
    return collect($yearsArray);
}


/**
 * @return \Illuminate\Support\Collection
 */
function fixedStatuses()
{
    return collect([
        ['label' => trans('admin.fixed'), 'value' => 'fixed'],
        ['label' => trans('admin.not_fixed'), 'value' => 'not_fixed']
    ]);
}


/**
 * @return \Illuminate\Support\Collection
 */
function statuses()
{
    return collect([
        ['label' => trans('admin.active'), 'value' => 'active'],
        ['label' => trans('admin.deactive'), 'value' => 'deactive']
    ]);
}

/**
 * @return string[]
 */
function fixedStatusesValues()
{
    return ['fixed', 'not_fixed'];
}

/**
 * @return string[]
 */
function statusesValues()
{
    return ['active', 'deactive'];
}

/**
 * @return string[]
 */
function statusesToggle()
{
    return ['active' => 'deactive', 'deactive' => 'active'];
}


/**
 * @return \Illuminate\Support\Collection
 */
function dimensionsClasses()
{
    return collect([
        ['label' => trans('admin.centimeter'), 'value' => 'centimeter'],
        ['label' => trans('admin.milimeter'), 'value' => 'milimeter'],
        ['label' => trans('admin.inch'), 'value' => 'inch']
    ]);
}


/**
 * @return \Illuminate\Support\Collection
 */
function weightClasses()
{
    return collect([
        ['label' => trans('admin.kilogram'), 'value' => 'kilogram'],
        ['label' => trans('admin.gram'), 'value' => 'gram'],
        ['label' => trans('admin.pound'), 'value' => 'pound'],
        ['label' => trans('admin.ounce'), 'value' => 'ounce']
    ]);
}

/**
 * @return string[]
 */
function dimensionsClassesValues()
{
    return ['centimeter', 'milimeter', 'inch'];
}

/**
 * @return string[]
 */
function weightClassesValues()
{
    return ['kilogram', 'gram', 'pound', 'ounce'];
}


/**
 * @return \Illuminate\Support\Collection
 */
function orderStatuses()
{
    return collect([
        ['label' => trans('admin.in_review'), 'value' => 'in_review'],
        ['label' => trans('admin.received'), 'value' => 'received'],
        ['label' => trans('admin.shipping'), 'value' => 'shipping'],
        ['label' => trans('admin.delivered'), 'value' => 'delivered'],
        ['label' => trans('admin.done'), 'value' => 'done'],
        ['label' => trans('admin.cancelled'), 'value' => 'cancelled'],
        ['label' => trans('admin.payment_failed'), 'value' => 'payment_failed'],
        ['label' => trans('admin.failed'), 'value' => 'failed'],
    ]);
}

/**
 * @return string[]
 */
function orderStatusesValues()
{
    return ['in_review', 'received', 'shipping', 'delivered', 'done', 'cancelled', 'payment_failed', 'failed'];
}

/**
 * @return string[]
 */
function notShowOnLogs()
{
    return [
        'password',
        'remember_token'
    ];
}


/**
 * @return mixed
 */
function getSetting()
{
    return \App\Models\Setting::get();
}


/***
 * @return \Illuminate\Support\Collection
 */
function days()
{
    $array = [];
    for ($i = 1; $i <= 31; $i++) {
        $array[] = ['label' => $i, 'value' => $i];
    }
    return collect($array);
}

/**
 * @return \Illuminate\Support\Collection
 */
function months()
{
    $array = [];
    for ($i = 1; $i <= 12; $i++) {
        $array[] = ['label' => $i, 'value' => $i];
    }
    return collect($array);
}

/***
 * @return \Illuminate\Support\Collection
 */
function years()
{
    $array = [];
    for ($i = 2021; $i <= 2050; $i++) {
        $array[] = ['label' => $i, 'value' => $i];
    }
    return collect($array);
}

/**
 * @return \Illuminate\Support\Collection
 */
function paymentMethods()
{
    return collect([
        ['label' => trans('admin.tabby'), 'value' => 'tabby'],
        ['label' => trans('admin.mada'), 'value' => 'mada'],
        ['label' => trans('admin.visa'), 'value' => 'visa'],
        ['label' => trans('admin.apple_pay'), 'value' => 'apple_pay'],
        ['label' => trans('admin.tamara'), 'value' => 'tamara'],
    ]);
}

/**
 * @return string[]
 */
function paymentMethodsValues()
{
    return ['tabby', 'mada', 'visa', 'apple_pay', 'tamara'];
}

/**
 * @return \Illuminate\Support\Collection
 */
function bankCardProviders()
{
    return collect([
        ['label' => trans('admin.mada'), 'value' => 'mada'],
        ['label' => trans('admin.visa'), 'value' => 'visa'],
    ]);
}

/**
 * @return string[]
 */
function bankCardProvidersValues()
{
    return ['mada', 'visa'];
}

/**
 * @return \Illuminate\Support\Collection
 */
function discountTypes()
{
    return collect([
        ['label' => trans('admin.fixed'), 'value' => 'fixed'],
        ['label' => trans('admin.percent'), 'value' => 'percent'],
    ]);
}

/**
 * @return string[]
 */
function discountTypesValues()
{
    return ['fixed', 'percent'];
}

/**
 * @return string[]
 */
function discountTypesMap()
{
    return ['fixed' => trans('admin.sar'), 'percent' => '%'];
}

/**
 * @return \Illuminate\Support\Collection
 */
function places()
{
    $placesOptions = [];
    foreach (placesValues() as $placeValue) {
        $placesOptions[] = ['label' => trans("admin.$placeValue"), 'value' => $placeValue];
    }
    return collect($placesOptions);
}

/**
 * @return string[]
 */
function placesValues()
{
    return ['home__after_slider__right', 'home__after_slider__left', 'home__before_special_products__right', 'home__before_special_products__left', 'home__before_testimonials'];
}
