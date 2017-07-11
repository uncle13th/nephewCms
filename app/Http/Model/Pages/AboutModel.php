<?php

namespace App\Http\Model\Pages;

use App\Http\Model\BaseModel;
use DB;

class AboutModel extends BaseModel
{

    protected $table = 'about';

    /*
     * 不能被批量赋值的属性
     */
    protected $guarded = [];

    /**
     * 获取关于我们列表（包含隐藏的,所有字段）
     * @return mixed
     */
    public function getAboutList(){
        $data = $this->where('status', '!=', -1)->orderBy('sort', 'asc')->get()->toArray();
        return $data;
    }

    /**
     * 获取可以在前端网站展示的关于我们页面内容（根据网站的语言获取不同的页面内容）
     * @param string $lang 语言
     * @return mixed
     */
    public function getAboutContent($lang = 'zh_cn'){
        if(empty($lang)){
            $lang = 'zh_cn';
        }
        $model = $this->where('status', 1)->where('lang', 'regexp', $lang)->orderBy('sort', 'asc')->first();
        if(is_null($model)){
            return false;
        }
        $data = $model->toArray();
        return $data;
    }

    /**
     * 新增关于我们信息
     * @param array $data 页面信息数据
     * @return bool|array
     */
    public function addData($data){
        if(empty($data) || empty($data['name']) || !isset($data['status']) || empty($data['description'])
            || empty($data['img']) || empty($data['lang'])){
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
     * 更新关于我们信息
     * @param array $data 页面信息数据
     * @return bool|array
     */
    public function updateData($data){
        if(empty($data) || empty($data['name']) || !isset($data['status']) || empty($data['description'])
            || empty($data['img']) || empty($data['lang']) || !isset($data['id']) || $data['id'] < 1){
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
     * 删除关于我们页面
     * @param int $id id
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
     * 保存关于我们页面的排序信息
     * @param array $order ID对应的顺序信息
     * @return bool
     */
    public function sortAboutList($order){
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
