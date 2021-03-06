<?php

// +----------------------------------------------------------------------
// | date: 2015-07-11
// +----------------------------------------------------------------------
// | SiteCatController.php: 后端网址菜单控制器
// +----------------------------------------------------------------------
// | Author: yangyifan <yangyifanphp@gmail.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\Admin\SiteCatModel;

use App\Http\Requests\Admin\SiteCatRequest;

class SiteCatController extends BaseController {

    protected $html_builder;

    /**
     * 构造方法
     *
     * @auther yangyifan <yangyifanphp@gmail.com>
     */
    public function __construct(HtmlBuilderController $html_builder){
        $this->html_builder = $html_builder;
    }

	/**
	 * 获得文章分类列表
	 *
	 * @return Response
     * @auther yangyifan <yangyifanphp@gmail.com>
	 */
	public function getIndex(){
        return  $this->html_builder->
                builderTitle('网址分类')->
                builderSchema('id', 'id')->
                builderSchema('cat_name', '分类名称')->
                builderSchema('pid_name','父级栏目')->
                builderSchema('status', '状态')->
                builderSchema('sort', '排序')->
                builderSchema('created_at', '创建时间')->
                builderSchema('updated_at', '更新时间')->
                builderSchema('handle', '操作')->
                builderAddBotton('增加网址分类', url('admin/site-cat/add'))->
                builderTreeData(SiteCatModel::getAll())->
                builderTree();
	}

    /**
     * 编辑文章分类
     *
     * @param  int  $id
     * @auther yangyifan <yangyifanphp@gmail.com>
     */
    public function getEdit($id){
        return  $this->html_builder->
                builderTitle('编辑网址分类')->
                builderFormSchema('id', 'id', 'hidden')->
                builderFormSchema('cat_name', '分类名称')->
                builderFormSchema('keywords', '分类关键字')->
                builderFormSchema('description', '分类描述', 'textarea')->
                builderFormSchema('pid', '父级菜单', 'select', $default = '',  $notice = '', $class = '', $rule = '*', $err_message = '', SiteCatModel::getAllForSchemaOption('cat_name', $id), 'cat_name')->
                builderFormSchema('status', '状态', 'radio', '', '', '', '', '', [1=>'开启', '2'=>'关闭'], '1')->
                builderFormSchema('sort', '菜单排序')->
                builderConfirmBotton('确认', url('admin/site-cat/edit'), 'btn btn-success')->
                builderEditData(SiteCatModel::find($id))->
                builderEdit();
    }

    /**
     * 处理更新文章分类
     *
     * @auther yangyifan <yangyifanphp@gmail.com>
     */
    public function postEdit(SiteCatRequest $request){
        $Model = SiteCatModel::findOrFail($request->get('id'));
        $Model->update($request->all());
        //更新成功
        return $this->response(200, trans('response.update_success'), [], true , url('admin/site-cat/index'));
    }

    /**
     * 增加文章分类
     *
     * @param  int  $id
     * @auther yangyifan <yangyifanphp@gmail.com>
     */
    public function getAdd(){
        return  $this->html_builder->
                builderTitle('增加菜单')->
                builderFormSchema('cat_name', '分类名称')->
                builderFormSchema('keywords', '分类关键字')->
                builderFormSchema('description', '分类描述', 'textarea')->
                builderFormSchema('pid', '父级菜单', 'select', $default = '',  $notice = '', $class = '', $rule = '*', $err_message = '', SiteCatModel::getAllForSchemaOption('cat_name'), 'cat_name')->
                builderFormSchema('status', '状态', 'radio', '', '', '', '', '', [1=>'开启', '2'=>'关闭'], '1')->
                builderFormSchema('sort', '菜单排序', 'text', 255)->
                builderConfirmBotton('确认', url('admin/site-cat/add'), 'btn btn-success')->
                builderAdd();
    }

    /**
     * 处理新增文章分类
     *
     * @auther yangyifan <yangyifanphp@gmail.com>
     */
    public function postAdd(SiteCatRequest $request){
        $affected_number = SiteCatModel::create($request->all());
        return $affected_number->id > 0 ? $this->response(200, trans('response.add_success'), [], true, url('admin/site-cat/index')) : $this->response(400, trans('response.add_error'), [], true, url('admin/article-cat/index'));
    }

}
