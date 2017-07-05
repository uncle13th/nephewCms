<?php

namespace App\Http\Model\Pages;

use App\Http\Model\BaseModel;
use DB;

class ProductTypeModel extends BaseModel
{

    protected $table = 'product_type';

    /*
     * 不能被批量赋值的属性
     */
    protected $guarded = [];

    /**
     * 获取产品类型信息（包含隐藏的）
     * @return mixed
     */
    public function getAllProductTypes(){
        $data = $this->where('status', '!=', -1)->orderBy('sort', 'asc')->get()->toArray();
        return $data;
    }

    /**
     * 获取可以在首页展示的产品类型
     * @param string $lang 语言
     * @return mixed
     */
    public function getIndexProductTypes($lang = 'zh_cn'){
        if(empty($lang)){
            $lang = 'zh_cn';
        }
        $data = $this->where('status', 1)->where('show', 1)->where('lang', 'regexp', $lang)->orderBy('sort', 'asc')->get()->toArray();
        return $data;
    }


    /**
     * 新增产品类型
     * @param array $data 产品类型信息数组
     * @return bool|array
     */
    public function addData($data){
        if(empty($data) || empty($data['name']) || !isset($data['status']) || !isset($data['show'])|| empty($data['lang'])){
            return false;
        }

        //判断名字是否被使用了
        $num = $this->where('status', '!=', -1)->where('name', $data['name'])->count();
        if($num > 0){
            return false;
        }

        $model = new static($data);
        if(!$model->save()){
            return false;
        }
        return $model->toArray();
    }

    /**
     * 更新产品类型信息
     * @param array $data 产品类型信息数组
     * @return bool|array
     */
    public function updateData($data){
        if(empty($data) || !isset($data['id']) || $data['id'] < 1 || empty($data['name']) || !isset($data['status'])
            || !isset($data['show']) || empty($data['lang'])){
            return false;
        }

        $num = $this->where('status', '!=', -1)->where('id','!=', $data['id'])->where('name', $data['name'])->count();
        if($num > 0){
            return false;
        }

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
     * 删除产品类型
     * @param int $id 产品类型id
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
     * 保存产品类型的排序信息
     * @param array $order 产品类型ID对应的顺序信息
     * @return bool
     */
    public function sortProductType($order){
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
}
