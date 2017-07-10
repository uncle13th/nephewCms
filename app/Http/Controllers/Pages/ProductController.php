<?php

namespace App\Http\Controllers\Pages;
use App\Http\Controllers\Controller;
use App\Http\Logic\Pages\ProductLogic;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showTypePage()
    {

        $logic = ProductLogic::getInstance();
        $types = $logic->getAllProductTypes();


        $pageIndex = 1002;  //页面索引，管理后台左侧菜单使用

        $data = array(
            'types' => $types,
            'pageIndex' => $pageIndex,
        );
        return view('home.pages.productType', $data);
    }

    /*
     * 保存产品类型信息
     */
    public function saveProductType(Request $request){
        $inputs = $request->input();
        $logic = ProductLogic::getInstance();
        $result =$logic->saveProductType($inputs);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 删除产品类型
     */
    public function deleteProductType(Request $request)
    {
        $id = $request->input('id');
        $logic = ProductLogic::getInstance();
        $result = $logic->deleteProductType($id);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 保存产品类型排序信息
     */
    public function sortProductType(Request $request)
    {
        $order = $request->input('order');
        $logic = ProductLogic::getInstance();
        $result = $logic->sortProductType($order);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 展示产品列表页面.
     */
    public function showListPage(Request $request)
    {
        $inputs = $request->input();
        $type_id = max(0, intval($request->input('type')));
        $status = max(-1, $request->input('status'));
        $id = max(0, intval($request->input('id')));
        $name = trim($request->input('name'));

        $logic = ProductLogic::getInstance();
        $types = $logic->getProductTypeMenu();
        $product_list = $logic->getProductList($type_id, $status, $id, $name);

        $params = [];
        $jsonParams = '';
        $tmp = [];
        if(isset($inputs['type'])){
            $params['type'] = $type_id;
            $tmp[] = "type=$type_id";
        }
        if(isset($inputs['status'])){
            $params['status'] = $status;
            $tmp[] = "status=$status";
        }
        if(isset($inputs['id'])){
            $params['id'] = $id;
            $tmp[] = "id=$id";
        }
        if(isset($inputs['name'])){
            $params['name'] = $name;
            $tmp[] = "name=$name";
        }

        if(!empty($tmp)){
            $jsonParams = '?'.implode('&', $tmp);
        }

        $pageIndex = 1003;  //页面索引，管理后台左侧菜单使用

        $data = array(
            'types' => $types,
            'type_id' => $type_id,
            'product_list' => $product_list,
            'status' => $status,
            'params' => $params,
            'jsonParams' => $jsonParams,
            'pageIndex' => $pageIndex,
        );

        return view('home.pages.productList', $data);
    }
    /*
     * 删除产品类型
     */
    public function deleteProduct(Request $request)
    {
        $id = $request->input('id');
        $logic = ProductLogic::getInstance();
        $result = $logic->deleteProduct($id);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     * 保存产品类型排序信息
     */
    public function sortProductList(Request $request)
    {
        $order = $request->input('order');
        $logic = ProductLogic::getInstance();
        $result = $logic->sortProductList($order);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }

    /*
     *展示产品详情页
     */
    public function showInfoPage(Request $request)
    {
        $logic = ProductLogic::getInstance();
        $inputs = $request->input();
        if(isset($inputs['id']) && !empty($inputs['id'])){
            $action = 'edit';
            $id = intval($inputs['id']);

            $info = $logic->getProductInfo($id);
        }else{
            $action = 'add';
            $id = 0;
            $info = [];
        }

        //获取产品类型下拉菜单
        $types = $logic->getProductTypeMenu();

        $pageIndex = 1003;  //页面索引，管理后台左侧菜单使用
        $data = array(
            'action' => $action,
            'id' => $id,
            'info' => $info,
            'types' => $types,
            'pageIndex' => $pageIndex,
        );
        return view('home.pages.productInfo', $data);
    }

    /*
     * 保存产品信息
     */
    public function saveProduct(Request $request){
        $inputs = $request->input();
        $logic = ProductLogic::getInstance();
        $result =$logic->saveProduct($inputs);
        if($result === false){
            return response()->json(['code' => $logic->errorCode, 'msg' => $logic->errorMessage]);
        }

        return response()->json(['code' => '200', 'msg' => '']);
    }
}
