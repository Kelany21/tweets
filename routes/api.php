<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/shipment/webhook', function (Request $request){
//    \App\Models\Shipment::where('waybill', 'OS00460299KS')->update(['status'=> $request->get('message')['status_code']]);
    if ($request->get('message')['waybill']){
        $waybills = [$request->get('message')['waybill']];
    }else {
        $waybills = $request->get('message')['waybills'];
    }
    \App\Models\Shipment::whereIn('waybill', $waybills)->update(['status'=> $request->get('message')['status_code']]);
    $ordersMap = SaeeMapShipmentStatusToOrderStatus();
    if (isset($ordersMap[$request->get('message')['status_code']])){
        $ordersIds = \App\Models\Shipment::whereIn('waybill', $waybills)->pluck('order_id');
        \App\Models\Order::whereIn('id', $ordersIds)->update(['deliver_status'=> $ordersMap[$request->get('message')['status_code']]]);
    }
    return response()->json([
        'response_code' => 200,
        "message" => "Notification Received successfully"
    ]);
})->middleware('api');
