<?php

namespace App\Http\Model\Pages;

use App\Http\Model\BaseModel;
use DB;

class BannerModel extends BaseModel
{

    protected $table = 'index_banner';

    /*
     * 不能被批量赋值的属性
     */
    protected $guarded = [];

    /**
     * 获取轮播图信息（包含隐藏的）
     * @return mixed
     */
    public function getAllBanners(){
        $data = $this->where('status', '!=', -1)->orderBy('sort', 'asc')->get()->toArray();
        return $data;
    }

    /**
     * 获取可以在首页展示的轮播图
     * @param string $lang 语言
     * @return mixed
     */
    public function getIndexBanners($lang = 'zh_cn'){
        if(empty($lang)){
            $lang = 'zh_cn';
        }
        $data = $this->where('status', 1)->where('lang', 'regexp', $lang)->orderBy('sort', 'asc')->get()->toArray();
        return $data;
    }

    /**
     * 新增轮播图
     * @param array $data 轮播图信息数组
     * @return bool|array
     */
    public function addData($data){
        if(empty($data) || empty($data['title']) || !isset($data['status']) || empty($data['url']) || empty($data['img'])
            || empty($data['lang']) || empty($data['target'])){
            return false;
        }

        //判断名字是否被使用了
        $num = $this->where('status', '!=', -1)->where('title', $data['title'])->count();
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
     * 更新轮播图信息
     * @param array $data 轮播图信息数组
     * @return bool|array
     */
    public function updateData($data){
        if(empty($data) || !isset($data['id']) || $data['id'] < 1 || empty($data['title']) || !isset($data['status'])
            || empty($data['url']) || empty($data['img']) || empty($data['lang']) || empty($data['target'])){
            return false;
        }

        $num = $this->where('status', '!=', -1)->where('id','!=', $data['id'])->where('title', $data['title'])->count();
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
     * 删除轮播图
     * @param int $id 轮播图id
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
     * 保存轮播图排序信息
     * @param array $order 轮播图ID对应的顺序信息
     * @return bool
     */
    public function sortBanners($order){
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
     * 修改轮播图的图片
     * @param int $id 轮播图id
     * @param string $img 图片地址
     * @return bool
     */
    public function updateBannerImage($id, $img){
        if(!is_numeric($id) || $id < 1 || empty($img)){
            return false;
        }

        $model = $this->where('id', $id)->where('status', '!=', -1)->first();
        if(is_null($model)){
            return false;
        }
        $data['img'] = $img;
        if(!$model->update($data)){
            return false;
        }
        return true;
    }
}
