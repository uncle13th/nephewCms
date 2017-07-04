<?php

namespace App\Http\Model\system;

use App\Http\Model\BaseModel;
use DB;

class ConfigModel extends BaseModel
{

    protected $table = 'system_config';

    /*
     * 不能被批量赋值的属性
     */
    protected $guarded = [];

    /**
     * 获取首页配置信息
     * @return array
     */
    public function getIndexConfig(){
        //1.获取首页轮播图数量上限
        $model = $this->where('name', 'banner_num')->first();
        if(is_null($model)){
            $data['banner_num'] = 10;
        }else{
            $info = $model->toArray();
            $data['banner_num'] = $info['value'];
        }

        //2.获取首页产品位的数量
        $model = $this->where('name', 'product_num')->first();
        if(is_null($model)){
            $data['product_num'] = 10;
        }else{
            $info = $model->toArray();
            $data['product_num'] = $info['value'];
        }

        return $data;
    }

    /**
     * 保存首页配置信息
     * @param int $bannerNum 首页轮播图数量的上限
     * @param int $indexProductNum 首页展示的产品位置的数量
     * @return bool
     */
    public function saveIndexConfig($bannerNum, $indexProductNum){

        DB::beginTransaction();

        DB::table($this->table)->where('name','banner_num')->update(['value' => $bannerNum]);
        DB::table($this->table)->where('name', 'product_num')->update(['value' => $indexProductNum]);

        DB::commit();
        return true;
    }
}
