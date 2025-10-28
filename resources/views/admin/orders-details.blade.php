@extends('layouts.admin')
@section('content')
    <style>
        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Order Details</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Order Items</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Ordered Items</h5>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('admin.orders') }}">Back</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Order No</th>
                            <td>{{ $orders->id }}</td>
                            <th>Mobile</th>
                            <td>{{ $orders->phone }}</th>
                            <th>Zip code</th>
                            <td>{{ $orders->zip }}</th>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{{ $orders->created_at }}</td>
                            <th>Delivered date</th>
                            <td>{{ $orders->delivery_date }}</th>
                            <th>Canceled date</th>
                            <td>{{ $orders->canceled_date }}</th>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td colspan="5">
                                @if ($orders->status == 'delivered')
                                    <span class="badge bg-success">Delivered</span>
                                @elseif($orders->status == 'canceled')
                                    <span class="badge bg-danger">Canceled</span>
                                @else
                                    <span class="badge bg-warning">Ordered</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                            <h5>Ordered Items</h5>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <th>Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Options</th>
                                <th class="text-center">Return Status</th>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                    <tr>
                                        <td class="pname">
                                            <div class="image">
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}" class="image">
                                            </div>
                                            <div class="name">
                                                <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}"
                                                    target="_blank" class="body-title-2">{{ $item->product->name }}</a>
                                            </div>
                                        </td>
                                        <td class="text-center">${{ $item->price }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-center">{{ $item->product->SKU }}</td>
                                        <td class="text-center">{{ $item->product->category->name }}</td>
                                        <td class="text-center">{{ $item->product->brand->name }}</td>
                                        <td class="text-center">{{ $item->options }}</td>
                                        <td class="text-center">{{ $item->rstatus == 0 ? 'No' : 'Yes' }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{ $orderItems->links('pagination::bootstrap-5') }}
                    </div>
                </div>

                <div class="wg-box mt-5">
                    <h5>Shipping Address</h5>
                    <div class="my-account__address-item col-md-6">
                        <div class="my-account__address-item__detail">
                            <p>{{ $orders->name }}</p>
                            <p>{{ $orders->address }}</p>
                            <p>{{ $orders->localcity }}</p>
                            <p>{{ $orders->city }} , {{ $orders->country }}</p>
                            <p>{{ $orders->landmark }}</p>
                            <p>{{ $orders->zip }}</p>
                            <br>
                            <p>Mobile : {{ $orders->phone }}</p>
                        </div>
                    </div>
                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                            <h5>Transaction</h5>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>{{ $orders->subtotal }}</td>
                                    <th>Tax</th>
                                    <td>{{ $orders->tax }}</td>
                                    <th>Discount</th>
                                    <td>{{ $orders->discount }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>{{ $orders->total }}</td>
                                    <th>Payment Mode</th>
                                    <td>{{ $transactions->mode }}</td>
                                    <th>Status</th>
                                    <td>{{ $transactions->status }}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{ $orders->created_at }}</td>
                                    <th>Delivered Date</th>
                                    <td>{{ $orders->delivery_date }}</td>
                                    <th>Canceled Date</th>
                                    <td>{{ $orders->canceled_date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endsection
