<div class="card card-custom card-sticky" id="kt_page_sticky_card">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>city</th>
                <th>location details</th>
                <th>total price</th>
                <th>products</th>
                <th>deliver status</th>
                <th>payment method</th>
                <th>created at</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $item)
                @php
                    $productString = '';
                    foreach ($item->carts as $cart){
                        $productString .= $cart->product->name . '(' . $cart->quantity . ')';
                    }
                @endphp
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->location->city->name}}</td>
                    <td>{{$item->location->details}}</td>
                    <td>{{$item->total_price}}</td>
                    <td>{{ $productString }}</td>
                    <td>{{$item->deliver_status}}</td>
                    <td>{{$item->transaction->payment_method}}</td>
                    <td>{{$item->created_at}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
