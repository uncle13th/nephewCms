@extends('layouts.front')

@section('content')

    <div class="met-banner-ny vertical-align text-center" style=''>
        <h2 class="vertical-align-middle">关于</h2>
    </div>

    <div class="met-column-nav ">
        <div class="container">
            <div class="row">
                <div class="sidebar-tile">
                    <ul class="met-column-nav-ul">
                        <li>
                            <a href="/about" title="关于我们" @if($type == 1) class="link active" @else class="link " @endif >关于我们</a>
                        </li>
                        <li>
                            <a href="/connect" title="联系我们" @if($type == 2) class="link active" @else class="link " @endif >联系我们</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="met-show animsition">
        <div class="container">
            <div class="row">
                <div class="met-editor lazyload clearfix">
                    <div><p>
                        <div class="lg-item-box" data-src="{{$data['img']}}" data-exthumbimage="{{$data['img']}}"><img class="" height="200" data-original="{{$data['img']}}" src="{{$data['img']}}" style="display: inline;"></div>
                        </p>

                        <hr/>
                        @if(!empty($data))
                            @foreach($data['content'] as $content)
                        <p>{{$content}}</p>
                            @endforeach
                        @endif
                </div>
            </div>
        </div>
    </section>


@endsection

@section('java-script')

@endsection
