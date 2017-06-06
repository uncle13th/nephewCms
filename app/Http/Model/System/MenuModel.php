<?php

namespace App\Http\Model\system;

use App\Http\Model\BaseModel;


class MenuModel extends BaseModel
{

    protected $table = 'system_menu';

    /*
     * 不能被批量赋值的属性
     */
    protected $guarded = [];

    /**
     * 获取有效的菜单
     * @return mixed
     */
    public function getAvaliableList(){
        return $this->where('status', 1)->get()->toArray();
    }
}
