@extends('layouts.front')

@section('content')

    <div class="met-banner-ny vertical-align text-center" style=''>
        <h1 class="vertical-align-middle">产品</h1>
    </div>

    <div class="met-column-nav bordernone">
        <div class="container">
            <div class="row">

                <div class="sidebar-tile">
                    <ul class="met-column-nav-ul invisible-xs">
                        @if(!empty($product_types))
                            @foreach($product_types as $product_type)
                                <li>
                                    <a href="/product/list?type={{$product_type['id']}}" title="{{$product_type['name']}}"
                                        @if($type == $product_type['id']) class="link active" @else  class="link" @endif>{{$product_type['name']}}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="met-product animsition type-1">
        <div class="container">
            <ul class="blocks-2 blocks-sm-2 blocks-md-4 blocks-xlg-4  met-page-ajax met-grid" id="met-grid" data-scale='1'>
                @if($product_list->count() > 0)
                    @foreach($product_list as $list)
                <li class=" shown">
                    <div class="widget widget-shadow">
                        <figure class="widget-header cover">
                            <a href="/product/info?id={{$list->id}}" title="{{$list->name}}" target='_self'>
                                <?php
                                $img = '';
                                if(!empty($list->img)) {
                                    $temp = explode(';', $list->img);
                                    $img = $temp[0];
                                }
                                ?>
                                <img class="cover-image" src="{{$img}}" alt="{{$list->name}}" style='height:200px;'>
                            </a>
                        </figure>
                        <h4 class="widget-title">
                            <a href="/product/info?id={{$list->id}}" title="{{$list->name}}" target='_self'>{{$list->name}}</a>
                            <p class='margin-bottom-0 margin-top-5 red-600'>2288.00元</p>
                        </h4>
                    </div>
                </li>
                    @endforeach
                @endif
            </ul>

            @if($product_list->total() > 0)
                <div class="box-footer clearfix" style="text-align: center;">
                    {{ $product_list->links("vendor.pagination.page") }}
                </div>
            @endif
        </div>
    </div>

@endsection

@section('java-script')
    {{--<script type="text/javascript" src="front/list.js"></script>--}}
@endsection
