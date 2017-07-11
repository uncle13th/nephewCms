<?php

namespace App\Http\Model\Pages;

use App\Http\Model\BaseModel;
use DB;

class ProductListModel extends BaseModel
{

    protected $table = 'product_list';

    /*
     * 不能被批量赋值的属性
     */
    protected $guarded = [];

    /**
     * 获取产品列表信息（包含隐藏的）
     * @param int $type_id 产品类型id
     * @param int $status 状态： -1：全部；1-有效；0-无效
     * @param int $id 产品ID
     * @param string $name 产品名称
     * @return mixed
     */
    public function getProductList($type_id = 0, $status = -1, $id = 0, $name = ''){
        if($status == -1){
            $model = $this->where('status', '!=', -1);
        }else{
            $model = $this->where('status', $status);
        }

        if($id > 0){
            $model = $model->where('id', $id);
        }

        if($name != ''){
            $model = $model->where('name', 'regexp', $name);
        }

        if($type_id == 0){
            $data = $model->orderBy('sort', 'asc')->get()->toArray();
        }else{
            $data = $model->where('type', $type_id)->orderBy('sort', 'asc')->get()->toArray();
        }

        return $data;
    }

    /**
     * 获取可以在首页展示的产品（根据网站的语言获取不同的产品类型信息）
     * @param int $product_type 产品类型id
     * @param string $lang 语言
     * @param int $limit_num 展示的条数
     * @return array
     */
    public function getIndexProductList($product_type, $lang = 'zh_cn', $limit_num = 8){
        if(empty($lang)){
            $lang = 'zh_cn';
        }
        if($product_type == 0){
            $data = $this->where('status', 1)->where('lang', 'regexp', $lang)->orderBy('sort', 'asc')->limit($limit_num)->get()->toArray();
        }else{
            $data = $this->where('status', 1)->where('type', $product_type)->where('lang', 'regexp', $lang)->orderBy('sort', 'asc')->limit($limit_num)->get()->toArray();
        }

        return $data;
    }

    /**
     * 获取产品信息
     * @param int $id 产品id
     * @return bool
     */
    public function getProductInfo($id){
        if(!is_numeric($id) || $id < 1){
            return false;
        }

        $model = $this->where('id', $id)->where('status', '!=', -1)->first();
        if(is_null($model)){
            return false;
        }

        return $model->toArray();
    }

    /**
     * 新增产品类型
     * @param array $data 产品信息数组
     * @return bool|array
     */
    public function addData($data){
        if(empty($data) || empty($data['name']) || !isset($data['status']) || !isset($data['type'])|| empty($data['lang'])){
            return false;
        }

        //判断名字是否被使用了
//        $num = $this->where('status', '!=', -1)->where('name', $data['name'])->count();
//        if($num > 0){
//            return false;
//        }

        $model = new static($data);
        if(!$model->save()){
            return false;
        }
        return $model->toArray();
    }

    /**
     * 更新产品信息
     * @param array $data 产品信息数组
     * @return bool|array
     */
    public function updateData($data){
        if(empty($data) || !isset($data['id']) || $data['id'] < 1 || empty($data['name']) || !isset($data['status'])
            || !isset($data['type']) || empty($data['lang'])){
            return false;
        }

//        $num = $this->where('status', '!=', -1)->where('id','!=', $data['id'])->where('name', $data['name'])->count();
//        if($num > 0){
//            return false;
//        }

        $model = $this->where('id', $data['id'])->where('status', '!=', -1)->first();
        if(is_null($model)){
            return false;
        }

        if(!$model->update($data)){
            return false;
        }
        return true;
    }

    /**
     * 删除产品
     * @param int $id 产品id
     * @return bool
     */
    public function deleteData($id){
        if(!is_numeric($id) || $id < 1){
            return false;
        }

        $model = $this->where('id', $id)->where('status', '!=', -1)->first();
        if(is_null($model)){
            return false;
        }

        $data['status'] = -1;
        if(!$model->update($data)){
            return false;
        }

        return true;
    }

    /**
     * 保存产品的排序信息
     * @param array $order 产品ID对应的顺序信息
     * @return bool
     */
    public function sortProductList($order){
        if(empty($order) || !is_array($order)){
            return false;
        }

        DB::beginTransaction();

        foreach($order as $id=>$sort){
            DB::table($this->table)->where('id', $id)->update(['sort' => $sort]);
        }

        DB::commit();
        return true;
    }

    /**
     * 根据产品类型和语言，获取产品的数量
     * @param int $type_id 产品类型ID
     * @param string $lang 语言
     * @return int
     */
    public function getProductCount($type_id = 0, $lang = 'zh_cn'){
        if(empty($lang)){
            $lang = 'zh_cn';
        }

        if($type_id == 0){
            $num = $this->where('status', 1)->where('lang', 'regexp', $lang)->count();
        }else{
            $num = $this->where('status', 1)->where('type', $type_id)->where('lang', 'regexp', $lang)->count();
        }

        return $num;
    }

    /**
     * 获取可以在前端网站展示的产品列表
     * @param int $type_id 产品类型id
     * @param string $lang 语言
     * @param int $per_page 每页展示的数据条数
     * @return mixed
     */
    public function getAvailableProductList($type_id, $lang = 'zh_cn', $per_page = 16){
        if(empty($lang)){
            $lang = 'zh_cn';
        }

        if($type_id == 0){
            $model = $this->where('status', 1)->where('lang', 'regexp', $lang)->paginate($per_page);
        }else{
            $model = $this->where('status', 1)->where('type', $type_id)->where('lang', 'regexp', $lang)->paginate($per_page);
        }

        return $model;
    }

    /**
     * 获取产品信息(允许在前端网站展示的产品信息)
     * @param int $id 产品id
     * @return bool
     */
    public function getAvailableProductInfo($id){
        if(!is_numeric($id) || $id < 1){
            return false;
        }

        $model = $this->where('id', $id)->where('status', 1)->first();
        if(is_null($model)){
            return false;
        }

        return $model->toArray();
    }
}
