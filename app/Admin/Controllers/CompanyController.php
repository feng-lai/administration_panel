<?php

namespace App\Admin\Controllers;

use App\Models\Company;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\CompanyExtraField;
use App\Models\CompanyExtraValue;
use Encore\Admin\Admin;

class CompanyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '公司管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Company());
        $grid->number('序号');
        $grid->rows(function ($row, $number) {
            $row->column('number', $number+1);
        });
        $grid->column('Company_name', '公司名称');
        //$grid->column('State', __('State'));
        $grid->column('Legal_representative', '法人');
        $grid->column('Registered_capital', '注册资本');
        $states = [
            'on'  => ['value' => 1, 'text' => '是', 'color' => 'primary'],
            'off' => ['value' => 0, 'text' => '否', 'color' => 'default'],
        ];
        $grid->column('recommend', '是否推荐')->switch($states);
        //$grid->column('Date_Incorporation', __('Date Incorporation'));
        //$grid->column('Approval_date', __('Approval date'));
        //$grid->column('Province', __('Province'));
        //$grid->column('City', __('City'));
        //$grid->column('District', __('District'));
        $grid->column('Tel_num', '电话');
        //$grid->column('More_tel_num', __('More tel num'));
        $grid->column('Email', '邮箱');
        //$grid->column('More_email', __('More email'));
        //$grid->column('Unified_social_credit_code', __('Unified social credit code'));
        //$grid->column('Taxpayer_identification_number', __('Taxpayer identification number'));
        //$grid->column('Registration_number', __('Registration number'));
        //$grid->column('Organization_code', __('Organization code'));
        //$grid->column('Number_people', __('Number people'));
        //$grid->column('Enterprise_type', __('Enterprise type'));
        //$grid->column('Industry', __('Industry'));
        //$grid->column('Name_used', __('Name used'));
        //$grid->column('url', __('Url'));
        //$grid->column('Address', __('Address'));
        //$grid->column('Address_update', __('Address update'));
        //$grid->column('Business_scope', __('Business scope'));
        //$grid->column('logDateTime', __('LogDateTime'));
        //$grid->column('created_at', __('Created at'));
        //$grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Company::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('Company_name', __('Company name'));
        $show->field('State', __('State'));
        $show->field('Legal_representative', __('Legal representative'));
        $show->field('Registered_capital', __('Registered capital'));
        $show->field('Date_Incorporation', __('Date Incorporation'));
        $show->field('Approval_date', __('Approval date'));
        $show->field('Province', __('Province'));
        $show->field('City', __('City'));
        $show->field('District', __('District'));
        $show->field('Tel_num', __('Tel num'));
        $show->field('More_tel_num', __('More tel num'));
        $show->field('Email', __('Email'));
        $show->field('More_email', __('More email'));
        $show->field('Unified_social_credit_code', __('Unified social credit code'));
        $show->field('Taxpayer_identification_number', __('Taxpayer identification number'));
        $show->field('Registration_number', __('Registration number'));
        $show->field('Organization_code', __('Organization code'));
        $show->field('Number_people', __('Number people'));
        $show->field('Enterprise_type', __('Enterprise type'));
        $show->field('Industry', __('Industry'));
        $show->field('Name_used', __('Name used'));
        $show->field('url', __('Url'));
        $show->field('Address', __('Address'));
        $show->field('Address_update', __('Address update'));
        $show->field('Business_scope', __('Business scope'));
        $show->field('logDateTime', __('LogDateTime'));
        $show->field('recommend', '是否推荐')->as(function($data){
            if($data == 0){
                return '否';
            }else{
                return '是';
            }
        });
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
        $form = new Form(new Company());

        $form->text('Company_name', __('Company name'));
        $form->text('State', __('State'));
        $form->text('Legal_representative', __('Legal representative'));
        $form->text('Registered_capital', __('Registered capital'));
        $form->text('Date_Incorporation', __('Date Incorporation'));
        $form->text('Approval_date', __('Approval date'));
        $form->text('Province', __('Province'));
        $form->text('City', __('City'));
        $form->text('District', __('District'));
        $form->text('Tel_num', __('Tel num'));
        $form->text('More_tel_num', __('More tel num'));
        $form->text('Email', __('Email'));
        $form->text('More_email', __('More email'));
        $form->text('Unified_social_credit_code', __('Unified social credit code'));
        $form->text('Taxpayer_identification_number', __('Taxpayer identification number'));
        $form->text('Registration_number', __('Registration number'));
        $form->text('Organization_code', __('Organization code'));
        $form->text('Number_people', __('Number people'));
        $form->text('Enterprise_type', __('Enterprise type'));
        $form->text('Industry', __('Industry'));
        $form->text('Name_used', __('Name used'));
        $form->text('url', __('Url'));
        $form->textarea('Address', __('Address'));
        $form->textarea('Address_update', __('Address update'));
        $form->textarea('Business_scope', __('Business scope'));
        $form->datetime('logDateTime', __('LogDateTime'))->default(date('Y-m-d H:i:s'));
        $form->switch('recommend')->default(0);
       /*** $fields = CompanyExtraField::where([['id','>','26']])->get();
        foreach($fields as $v){
            $form->html('<div class="layui-form-item"><div class="layui-input-block" style="margin-left:0"><input type="text" name="'.$v->name.'" autocomplete="off" class="layui-input"></div></div>',$v->name); 
        }
        
        
        $form->saved(function (Form $form) {
            $id = $form->model()->id;
            $fields = CompanyExtraField::select('id','name')->where([['id','>','26']])->get();
            foreach($fields as $v){
                $is = CompanyExtraValue::where(['fid'=>$v->id,'cid'=>$id])->value('id');
                if($is){
                    $res = CompanyExtraValue::find($is);
                }else{
                    $res = new CompanyExtraValue;
                }
                $res->fid = $v->id;
                $res->name = $v->name;
                $res->cid = $id;
                $res->save();
                dd($form->toArray());
                
                
            }
        });**/
        return $form;
    }
}
