<?php

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Create order (Last Mile Booking)
 * @param float $cashOnDelivery
 * @param string $name
 * @param int $mobile
 * @param string $streetAddress
 * @param string $city
 * @param float $weight
 * @param int $quantity
 * @param array $optionalParams
 * @return array
 */
function SaeeLastMileBooking(float $cashOnDelivery, string $name, int $mobile, string $streetAddress, string $city,
                             float $weight, int $quantity, array $optionalParams = []): array
{
    $secret = env("SAEE_SECRET");
    $baseUrl = env("SAEE_BASE_URL");
    return Http::withHeaders([
        'Content-Type' => 'application/json; charset=utf-8'
    ])->post($baseUrl.'/deliveryrequest/new', array_merge([
        'secret' => $secret,
        'cashondelivery' => $cashOnDelivery,
        'name' => $name,
        'mobile' => $mobile,
        'streetaddress' => $streetAddress,
        'city' => $city,
        'weight' => $weight,
        'quantity' => $quantity,
    ], $optionalParams))->json();
}

/**
 * Create Order (Pickup Shipments)
 * @param float $cashOnPickup
 * @param float $cashOnDelivery
 * @param string $pName
 * @param int $pMobile
 * @param string $pStreetAddress
 * @param string $pCity
 * @param string $cName
 * @param int $cMobile
 * @param string $cStreetAddress
 * @param string $cCity
 * @param float $weight
 * @param int $quantity
 * @param array $optionalParams
 * @return array
 */
function SaeePickupShipments(float $cashOnPickup, float $cashOnDelivery, string $pName, int $pMobile, string $pStreetAddress, string $pCity,
                             string $cName, int $cMobile, string $cStreetAddress, string $cCity, float $weight,
                             int $quantity, array $optionalParams = []): array
{
    $secret = env("SAEE_SECRET");
    $baseUrl = env("SAEE_BASE_URL");
    return Http::withHeaders([
        'Content-Type' => 'application/json; charset=utf-8'
    ])->post($baseUrl.'/deliveryrequest/newpickup', array_merge([
        'secret' => $secret,
        'cashonpickup' => $cashOnPickup,
        'cashondelivery' => $cashOnDelivery,
        'p_name' => $pName,
        'p_mobile' => $pMobile,
        'p_streetaddress' => $pStreetAddress,
        'p_city' => $pCity,
        'c_name' => $cName,
        'c_mobile' => $cMobile,
        'c_streetaddress' => $cStreetAddress,
        'c_city' => $cCity,
        'weight' => $weight,
        'quantity' => $quantity,
    ], $optionalParams))->json();
}

/**
 * Reverse Pickup Order (Reserve Pickup From Consignee)
 * @param float $cashOnPickup
 * @param string $pName
 * @param int $pMobile
 * @param string $pStreetAddress
 * @param string $pCity
 * @param float $weight
 * @param int $quantity
 * @param array $optionalParams
 * @return array
 */
function SaeeReservePickupFromConsignee(float $cashOnPickup, string $pName, int $pMobile, string $pStreetAddress, string $pCity,
                             float $weight, int $quantity, array $optionalParams = []): array
{
    $secret = env("SAEE_SECRET");
    $baseUrl = env("SAEE_BASE_URL");
    return Http::withHeaders([
        'Content-Type' => 'application/json; charset=utf-8'
    ])->post($baseUrl.'/deliveryrequest/reversepickup', array_merge([
        'secret' => $secret,
        'cashonpickup' => $cashOnPickup,
        'p_name' => $pName,
        'p_mobile' => $pMobile,
        'p_streetaddress' => $pStreetAddress,
        'p_city' => $pCity,
        'weight' => $weight,
        'quantity' => $quantity,
    ], $optionalParams))->json();
}

/**
 * Cancel order (Only when status of the order is pending)
 * @param string $waybill
 * @return array
 */
function SaeeCancelOrder(string $waybill): bool
{
    $secret = env("SAEE_SECRET");
    $baseUrl = env("SAEE_BASE_URL");
    return Http::withHeaders([
        'Content-Type' => 'application/json; charset=utf-8',
        'Accept' => '*/*',
        'Accept-Encoding' => 'gzip, deflat',
        'User-Agent' => 'runscope/0.1',
    ])->post($baseUrl.'/deliveryrequest/cancel', [
        'secret' => $secret,
        'waybill' => $waybill,
    ])->json() == 1;
}

/**
 * Create order (Last Mile Booking)
 * @param string $waybill
 * @param float $cashOnDelivery
 * @param string $name
 * @param int $mobile
 * @param string $streetAddress
 * @param string $city
 * @param float $weight
 * @param int $quantity
 * @param array $optionalParams
 * @return array
 */
function SaeeUpdateOrderDetails(string $waybill, float $cashOnDelivery, string $name, int $mobile, string $streetAddress, string $city,
                             float $weight, int $quantity, array $optionalParams = []): array
{
    $secret = env("SAEE_SECRET");
    $baseUrl = env("SAEE_BASE_URL");
    return Http::withHeaders([
        'Content-Type' => 'application/json; charset=utf-8'
    ])->post($baseUrl.'/deliveryrequest/update', array_merge([
        'secret' => $secret,
        'waybill' => $waybill,
        'cashondelivery' => $cashOnDelivery,
        'name' => $name,
        'mobile' => $mobile,
        'streetaddress' => $streetAddress,
        'city' => $city,
        'weight' => $weight,
        'quantity' => $quantity,
    ], $optionalParams))->json();
}

/**
 * Get Saee Available Cities
 * @param string $lang
 * @return \Illuminate\Support\Collection
 */
function SaeeGetCitiesInLabelValue(string $lang): \Illuminate\Support\Collection
{
    try {

        $result = [];
        if ($lang == "ar" || $lang == "en"){
            $baseUrl = env("SAEE_BASE_URL");
            $data = Http::withHeaders([
                'Content-Type' => 'application/json; charset=utf-8'
            ])->get($baseUrl.'/deliveryrequest/getallcities')->json();
            $cities = $data['cities'];
            foreach ($cities as $city){
                $result[] = [
                    'label' => $city[$lang == "ar" ? "name_ar" : "name"],
                    'value' => $city["name"]
                ];
            }
        }
        return collect($result);
    } catch (\Exception $exception){
        return collect([]);
    }
}

/**
 * Get Saee Available Cities
 * @return array
 */
function SaeeGetCities(): array
{
    try {
        $baseUrl = env("SAEE_BASE_URL");
        $data = Http::withHeaders([
            'Content-Type' => 'application/json; charset=utf-8'
        ])->get($baseUrl.'/deliveryrequest/getallcities')->json();
        $cities = $data['cities'];
        return \Illuminate\Support\Arr::pluck($cities, "name");
    } catch (\Exception $exception){
        return [];
    }
}

/**
 * @return \Illuminate\Support\Collection
 */
function SaeeShipmentStatusesDropDown()
{
    return collect([
        ['label' => trans('admin.in_sorting_area'), 'value' => 1001],
        ['label' => trans('admin.picked_up_from_supplier'), 'value' => 1002],
        ['label' => trans('admin.in_warehouse'), 'value' => 1003],
        ['label' => trans('admin.scheduled_for_delivery'), 'value' => 1008],
        ['label' => trans('admin.cancel'), 'value' => 1009],
        ['label' => trans('admin.ready_to_dispatch'), 'value' => 1104],
        ['label' => trans('admin.dispatched'), 'value' => 1004],
        ['label' => trans('admin.delivered'), 'value' => 1005],
        ['label' => trans('admin.failed_delivery_attempt'), 'value' => 1006],
        ['label' => trans('admin.returned_to_origin'), 'value' => 1007],
        ['label' => trans('admin.in_transit'), 'value' => 1109],
        ['label' => trans('admin.out_for_return'), 'value' => 1010],
        ['label' => trans('admin.request_for_replacement_of_return_to_origin_shipment'), 'value' => 1207],
        ['label' => trans('admin.request_confirmed_for_replacement_of_return_to_origin_shipment'), 'value' => 1307],
        ['label' => trans('admin.replacement_of_return_to_origin_shipment'), 'value' => 1407],
    ]);
}

/**
 * @return array
 */
function SaeeGetShipmentStatuses()
{
    return [
        1001 => trans('admin.in_sorting_area'),
        1002 => trans('admin.picked_up_from_supplier'),
        1003 => trans('admin.in_warehouse'),
        1008 => trans('admin.scheduled_for_delivery'),
        1009 => trans('admin.cancel'),
        1104 => trans('admin.ready_to_dispatch'),
        1004 => trans('admin.dispatched'),
        1005 => trans('admin.delivered'),
        1006 => trans('admin.failed_delivery_attempt'),
        1007 => trans('admin.returned_to_origin'),
        1109 => trans('admin.in_transit'),
        1010 => trans('admin.out_for_return'),
        1207 => trans('admin.request_for_replacement_of_return_to_origin_shipment'),
        1307 => trans('admin.request_confirmed_for_replacement_of_return_to_origin_shipment'),
        1407 => trans('admin.replacement_of_return_to_origin_shipment'),
    ];
}

/**
 * @return array
 */
function SaeeMapShipmentStatusToOrderStatus() : array
{
    return [
        1004 => 'on_delivery',
        1005 => 'delivered',
        1007 => 'retrieved',
        1010 => 'on_retrieve',
    ];
}
