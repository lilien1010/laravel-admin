<?php

// +----------------------------------------------------------------------
// | date: 2015-06-06
// +----------------------------------------------------------------------
// | RoleModel.php: 后端权限模型
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

namespace App\Model\Admin;

use App\Model\Admin\BaseModel;

use DB;

class RoleModel extends BaseModel {

    protected $table    = 'role';//定义表名
    protected $guarded  = ['id'];//阻挡所有属性被批量赋值

    /**
     * 组合角色数据
     *
     * @param $roles
     * @return mixed
     * @auther yangyifan <yangyifanphp@gmail.com>
     */
    public static function mergeData($data){
        if(!empty($data)){
            foreach($data as $v){
                //组合状态
                $v->status = self::mergeStatus($v->status);

                //组合编辑操作
                $v->handle  = '<a href="'.url('admin/role/edit', [$v->id]).'" target="_blank" >编辑</a>';
                $v->handle .= '&nbsp;';
                $v->handle .= '<a href="'.url('admin/role/edit', [$v->id]).'" target="_blank" >权限</a>';

            }
        }
        return $data;
    }

    /**
     * 获得角色列表
     *
     * @return mixed
     * @auther yangyifan <yangyifanphp@gmail.com>
     */
    public static function getRoleList(){
        //加载函数库
        load_func('common');
        return obj_to_array(DB::table('role')->where('status', '=', 1)->get());
    }

    /**
     * 获得角色消息信息
     *
     * @param $role_id
     * @return mixed
     */
    public static function getRoleInfo($role_id){
        return DB::table('role')->where('id', '=', (int)$role_id)->first();
    }

}
