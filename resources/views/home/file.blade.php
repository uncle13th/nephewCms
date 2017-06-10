@extends('layouts.main')

@section('location')
    <section class="content-header">
        <div class="container col-xs-12 col-sm-12 col-md-12">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <ol class="breadcrumb" style="font-size: 16px;background-color: #ecf0f5;">
                    <li><i class="fa fa-users"></i>系统管理</li>
                    <li class="active"><i class="fa fa-fw fa-paw"></i>文件上传管理</li>
                </ol>
            </div>
        </div>
    </section>

@endsection

@section('content')
    <div class="container" id="content-wrap">
        <div style="padding-right: 50px;">
            <div class="col-sm-12">
                <iframe src="/filemanager/dialog.php?editor=0&type=0&lang=zh_CN" class="filemanager" style="width: 100%;border: 0;min-height: 600px;"></iframe>
            </div>
        </div>
    </div>
@endsection
