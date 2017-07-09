@extends('layouts.main')
@section('css')
<link rel="stylesheet" href="{{asset('/plugins/fancybox/jquery.fancybox.css')}}" type="text/css" media="screen" />
@endsection

@section('location')
    <section class="content-header">
        <div class="container col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <ol class="breadcrumb" style="font-size: 16px;background-color: #ecf0f5;">
                    <li><i class="fa fa-users"></i>页面管理</li>
                    <li><i class="fa fa-fw fa-user"></i>产品列表管理</li>
                    <li class="active">
                        @if($action == 'add')
                            <i class="fa fa-fw fa-plus-circle"></i>新增产品信息
                        @else
                            <i class="fa fa-fw fa-edit"></i>修改产品信息
                        @endif
                    </li>
                </ol>
            </div>
        </div>
    </section>

@endsection

@section('content')
    <section class="content">
        <div style="min-height:30px;"></div>

        <div class="box box-primary">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="form-horizontal">
                    <input type="hidden" id="dataId" value="{{$id}}" >
                    <input type="hidden" id="operation" value="{{$action}}" >
                    <div class="box-body">
                        <div id="idArea" class="form-group" @if($action == 'add') style="display: none;" @else style="display: block;" @endif>
                            <label class="col-sm-2 control-label">产品ID</label>
                            <label class="col-sm-1 control-label">
                                @if($action == 'edit' && !empty($info['id']))
                                    {{$info['id']}}
                                @endif
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">产品名称</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" placeholder="产品名称"
                                    @if($action == 'edit' && !empty($info['name']))
                                        value="{{$info['name']}}"
                                    @endif
                                >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="product_type" class="col-sm-2 control-label">产品类型</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="product_type">
                                    @if(!empty($types))
                                        @foreach($types as $key => $value)
                                            <option value="{{$key}}" @if($action == 'edit' && $key == $info['type']) selected @endif >{{$value}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">简单描述</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" rows="3" id="description" placeholder="简单描述" ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">语言</label>
                            <div class="col-sm-10 lang-menu">
                                <div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" value="zh_cn" @if($action == 'edit' && strpos($info['lang'], 'zh_cn') !== false) checked @endif>简体中文</label>
                                        <label><input type="checkbox" value="zh_tw" @if($action == 'edit' && strpos($info['lang'], 'zh_tw') !== false) checked @endif>繁体中文</label>
                                        <label><input type="checkbox" value="en_us" @if($action == 'edit' && strpos($info['lang'], 'en_us') !== false) checked @endif>English</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 0px;">
                            <label for="status" class="col-sm-2 control-label">状态</label>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <div class="radio col-sm-12">
                                        <label>
                                            <input type="radio" name="status" value="1" @if($action == 'add' || ($action == 'edit' && $info['status'] == 1)) checked="checked" @endif>
                                            有效
                                        </label>

                                        <label style="margin-left: 10px;">
                                            <input type="radio" name="status" value="0" @if($action == 'edit' && $info['status'] == 0) checked="checked" @endif>
                                            隐藏
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $i=1; ?>
                        <!-- 修改产品信息 -->
                        @if($action == 'edit' && !empty($info['img']))
                        <div id="imageDiv" class="form-group">
                            @foreach($info['img'] as $img)
                            @if($i == 1) <label class="col-sm-2 control-label">产品图片</label> @endif
                            <div @if($i == 1) class="col-sm-6" @else class="col-sm-offset-2 col-sm-6" @endif  style="padding-bottom: 15px;">
                                <img style="width: 510px;min-height: 240px;" class="img-bordered" src="{{$img}}" alt="请点击选择图片按钮来添加图片">
                                <div class="input-group">
                                    <input id="img{{$i}}" class="img_src form-control" name="productImg" type="text" value="{{$img}}" src="" readonly>
                                    <span class="input-group-btn">
                                        <a href="/filemanager/dialog.php?type=1&amp;field_id=img{{$i++}}" class="btn btn-warning iframe-btn">选择图片</a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2" style="padding-top:100px;">
                                <button type="button" class="product-img-del btn btn-danger btn-sm">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="product-img-add btn bg-teal btn-sm">
                                    <i class="fa fa fa-plus"></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        @else
                            <!-- 新增产品信息 -->
                            <div id="imageDiv" class="form-group">
                                <label class="col-sm-2 control-label">产品图片</label>

                                <div class="col-sm-6"  style="padding-bottom: 15px;">
                                    <img style="width: 510px;min-height: 240px;" class="img-bordered" src="" alt="请点击选择图片按钮来添加图片">
                                    <div class="input-group">
                                        <input id="img{{$i}}" class="img_src form-control" name="productImg" type="text" value="" src="" readonly>
                                    <span class="input-group-btn">
                                        <a href="/filemanager/dialog.php?type=1&amp;field_id=img{{$i++}}" class="btn btn-warning iframe-btn">选择图片</a>
                                    </span>
                                    </div>
                                </div>
                                <div class="col-sm-2" style="padding-top:100px;">
                                    <button type="button" class="product-img-del btn btn-danger btn-sm">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="product-img-add btn bg-teal btn-sm">
                                        <i class="fa fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        @endif


                        <?php $j=1; ?>
                        @if($action == 'edit' && !empty($info['detail']))
                            <div id="detailDiv" class="form-group">
                                @foreach($info['detail'] as $detail)
                                    @if($j == 1) <label class="col-sm-2 control-label">产品内容</label> @endif
                                    <div @if($j++ == 1) class="col-sm-6" @else class="col-sm-offset-2 col-sm-6" @endif  style="padding-bottom: 15px;">
                                        <img style="width: 510px;min-height: 240px;" class="img-bordered" src="{{$detail}}" alt="请点击选择图片按钮来添加图片">
                                        <div class="input-group">
                                            <input id="detail{{$i}}" class="img_src form-control" name="productDetail" type="text" value="{{$detail}}" src="" readonly>
                                    <span class="input-group-btn">
                                        <a href="/filemanager/dialog.php?type=1&amp;field_id=detail{{$i++}}" class="btn btn-warning iframe-btn">选择图片</a>
                                    </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2" style="padding-top:100px;">
                                        <button type="button" class="product-detail-del btn btn-danger btn-sm">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="product-detail-add btn bg-teal btn-sm">
                                            <i class="fa fa fa-plus"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @else
                        <div id="detailDiv" class="form-group">
                            <label class="col-sm-2 control-label">产品内容</label>
                            <div class="col-sm-6" style="padding-bottom: 15px;">
                                <img style="width: 510px;min-height: 240px;" class="img-bordered" src="" alt="请点击选择图片按钮来添加图片">
                                <div class="input-group">
                                    <input id="detail{{$i}}" class="img_src form-control" name="productDetail" type="text" value="" src="" readonly>
                                    <span class="input-group-btn">
                                        <a href="/filemanager/dialog.php?type=1&amp;field_id=detail{{$i++}}" class="btn btn-warning iframe-btn">选择图片</a>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2" style="padding-top:100px;">
                                <button type="button" class="product-detail-del btn btn-danger btn-sm">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="product-detail-add btn bg-teal btn-sm">
                                    <i class="fa fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        @endif


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="form-group" style="margin-bottom: 0px;">
                            <div class="col-sm-offset-2 col-sm-8">
                                <p id="saveResult" class="text-green"></p>
                            </div>
                            <div class="col-sm-offset-2 col-sm-4">
                                <button id="saveData" class="btn btn-info">保存</button>
                                <button id="refreshData" class="btn btn-danger">取消</button>
                                <button id="returnPrev" class="btn btn-default">返回</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ csrf_field() }}
        <input type="hidden" id="indexId" value="{{$i}}">
        <input type="hidden" id="descId" @if($action == 'edit' && !empty($info['description']))
            value="{{$info['description']}}" @else value="" @endif>
    </section>

@endsection

@section('js')
    <script src="{{asset('/plugins/fancybox/jquery.fancybox.js')}}"></script>
    <script src="{{asset('/plugins/JQueryUI/jquery-ui.min.js')}}"></script>
    <script src="{{asset('/js/home/pages/productInfo.js')}}"></script>

@endsection