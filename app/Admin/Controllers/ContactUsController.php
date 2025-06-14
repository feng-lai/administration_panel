<?php

namespace App\Admin\Controllers;

use App\Models\ContactUs;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ContactUsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '联系我们管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ContactUs());

        $grid->number('序号');
        $grid->rows(function ($row, $number) {
            $row->column('number', $number+1);
        });
        $grid->column('title', __('Title'));
        $grid->column('content', __('Content'));
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
        $show = new Show(ContactUs::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
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
        $form = new Form(new ContactUs());

        $form->text('title', __('Title'));
        $form->editor('content', __('Content'));

        return $form;
    }
}
