<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '文章中心';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->number('序号');
        $grid->rows(function ($row, $number) {
            $row->column('number', $number+1);
        });
        $grid->column('title', __('Title'));
        $grid->column('status', '状态')->editable('select', [2 => '审核通过', 1 => '待审核', -1 => '审核不通过']); 
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Article::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('type', __('Type'))->as(function ($status) {
            if($status==1) {
                $status='我需要';
            }else if($status==2){
                $status='我提供';
            }
            return $status;    
        });
        $show->field('cid', __('Cid'))->as(function ($status) {
            if($status==1) { 
                $status='产品';
            }else if($status==2){
                $status='技术';
            }else if($status==3){
                $status='设备';
            }else if($status==4){
                $status='人工';
            }else if($status==5){
                $status='其他';
            }
            return $status;    
        });
        $show->field('title', __('Title'));
        $show->status('状态')->as(function ($status) {
            if($status==2) {
                $status='审核通过';
            }else if($status==1){
                $status='待审核';
            }else if($status==-1){
                $status='审核不通过';
            }
            return $status;    
        });
        $show->field('content', __('Content'));
        $show->field('file', __('File'))->unescape()->as(function ($status) {
            return '<a href="/storage/file/'.$status.'" target="_blank">'.$status.'</a>';    
        });
        $show->field('name', __('Name'));
        $show->field('phone', __('Phone'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());

        $form->switch('type', __('Type'))->default(1);
        $form->switch('cid', __('Cid'))->default(1);
        $form->text('title', __('Title'));
        $form->text('content', __('Content'));
        $form->select('status', '审核')->options([2 => '已通过', 1 => '待审核', -1 => '不通过']);
        $form->file('file', __('File'));
        $form->text('name', __('Name'));
        $form->mobile('phone', __('Phone'));

        return $form;
    }
}
