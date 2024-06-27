@extends('frontend.master')

@section('body')
<div class="courses-area-two section-bg ">
    <div class="container bg-white  pb-70 ps-3">
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="text-center mb-5">
                    <a href="javascript:void(0)" class="btn border-main-color"><span class="fw-bolder fs-2">আমাদের বই
                            সমূহ</span></a>
                </div>
                <div class="row product_mobile_res pro_book_mobile_res">
                    @foreach($products as $product)
                    <div class="col-lg-3 col-md-6">
                        <div class="blog-card">
                            <div class="book-btn-sec">
                                <a href="{{ route('front.product-details',['id'=>$product->id, 'slug'=>$product->slug]) }}"
                                    class="read-btn btn btn-warning">Read More</a>
                                @php
                                $stockStatus = false;
                                if ($product->stock_amount > 0)
                                {
                                $stockStatus = true;
                                }
                                @endphp
                                <p></p>
                                @if(!empty(\Cart::get($product->id)))
                                <a href="{{ route('front.view-cart') }}" class="default-btn ">এখনই কিনুন</a>
                                @else
                                @if($stockStatus == true)
                                <form action="{{ route('front.add-to-cart-home') }}" method="post"
                                    class="addSimpleCardFrom{{$product->id}}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                    <input type="hidden" name="price"
                                        value="{{ $product->has_discount_validity == 'true' ? $grandPrice : $product->price }}" />
                                    <a href="javascript:void(0)" onclick="addSimpleProCard({{$product->id}})"
                                        class="read-btn btn btn-warning cart_count-{{$product->id}} mt-1"> Add To Cart </a>
                                </form>
                                @endif
                                @endif
                            </div>

                            <div class="blog_card_img">

                                <img src="{{ asset($product->image ?? 'frontend/logo/biddabari-card-logo.jpg') }}"
                                    alt="{{ $product->title }}">

                            </div>
                            <div class="content">
                                <h3><a
                                        href="{{ route('front.product-details', ['id' => $product->id, 'slug' => $product->slug]) }}">{{
                                        $product->title }}</a></h3>
                                @if($stockStatus == true)
                                <p class="text-success f-s-19">In Stock</p>
                                @else
                                <p class="text-danger f-s-19">Out Of Stock</p>
                                @endif
                                <h5>TK {{$product->price}} </h5>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @if(count($products) > 0)
                    <div class="col-md-12 mt-5">
                        <div class="text-center">
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row col-12">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('style')
@endpush

@section('js')
@endsection
