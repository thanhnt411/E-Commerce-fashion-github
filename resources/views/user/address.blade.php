@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Addresses</h2>
            <div class="row">
                <div class="col-lg-3">
                    <ul class="account-nav">
                        <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s">Dashboard</a></li>
                        <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s">Orders</a></li>
                        <li><a href="account-address.html" class="menu-link menu-link_us-s menu-link_active">Addresses</a>
                        </li>
                        <li><a href="account-details.html" class="menu-link menu-link_us-s">Account Details</a></li>
                        <li><a href="account-wishlist.html" class="menu-link menu-link_us-s">Wishlist</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <a href="{{ route('logout') }}" class=""
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <div class="text">Logout</div>
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__address">
                        <div class="row">
                            <div class="col-6">
                                <p class="notice">The following addresses will be used on the checkout page by default.</p>
                            </div>
                            <div class="col-6 text-right">
                                <a href="#" class="btn btn-sm btn-info">Add New</a>
                            </div>
                        </div>
                        <div class="my-account__address-list row">
                            <h5>Shipping Address</h5>

                            <div class="my-account__address-item col-md-6">
                                <div class="my-account__address-item__title">
                                    <h5>{{ $orders->name }}<i class="fa fa-check-circle text-success"></i></h5>
                                    <a href="#">Edit</a>
                                </div>
                                <div class="my-account__address-item__detail">
                                    <p>{{ $orders->address }}</p>
                                    <p>{{ $orders->localcity }}</p>
                                    <p>{{ $orders->city }} , {{ $orders->country }}</p>
                                    <p>{{ $orders->landmark }}</p>
                                    <p>{{ $orders->zip }}</p>
                                    <br>
                                    <p>Mobile : {{ $orders->phone }}</p>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
