<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->number('序号');
        $grid->rows(function ($row, $number) {
            $row->column('number', $number+1);
        });
        $grid->column('name', __('Name'));
        $grid->column('profile_pic', __('Profile pic'))->display(function($img){
            return '<img src="/storage/userImg/'.$img.'" height="100">';
        });
        $grid->column('auths', __('Auths'))->display(function($auths){
            if($auths == 1){
                return '是';
            }else{
                return '否';
            }
        });
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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('profile_pic', __('Profile pic'));
        $show->field('auths', __('Auths'));
        $show->field('country', __('Country'));
        $show->field('province', __('Province'));
        $show->field('city', __('City'));
        $show->field('gender', __('Gender'));
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
        $form = new Form(new User());

        $form->text('name', __('Name'));
        $form->text('profile_pic', __('Profile pic'));
        $form->switch('auths', __('Auths'))->default(-1);
        $form->text('country', __('Country'));
        $form->text('province', __('Province'));
        $form->text('city', __('City'));
        $form->switch('gender', __('Gender'))->default(1);

        return $form;
    }
}
