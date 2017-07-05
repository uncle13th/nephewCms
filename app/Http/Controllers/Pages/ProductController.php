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

        $data = array(
            'types' => $types,
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
}
