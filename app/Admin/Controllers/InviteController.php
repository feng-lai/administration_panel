<?php

namespace App\Admin\Controllers;

use App\Models\Invite;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InviteController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '邀请用户列表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Invite());

        $grid->column('id', __('Id'));
        $grid->column('uid', '邀请方用户');
        $grid->column('invate_id', '被邀请用户');
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
        $show = new Show(Invite::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('uid', __('Uid'));
        $show->field('invate_id', __('Invate id'));
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
        $form = new Form(new Invite());

        $form->number('uid', __('Uid'));
        $form->number('invate_id', __('Invate id'));

        return $form;
    }
}
