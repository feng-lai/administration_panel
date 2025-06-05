<?php

namespace App\Admin\Controllers;

use App\Models\CompanyExtraField;
use App\Models\Company;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class CompanyExtraFieldController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '公司字段管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CompanyExtraField());
        // 全部关闭
        $grid->disableActions();
        $grid->disableCreation();

        /**$columns = Schema::getColumnListing('companies');
        unset($columns[0]);
        unset($columns[27]);
        unset($columns[28]);
        unset($columns[29]);
        unset($columns[30]);
        $columns = array_values($columns);
        foreach($columns as $v){
            $fields = new CompanyExtraField;
            $fields->name = $v;
            $fields->save();
        }**/
        $grid->number('序号');
        $grid->rows(function ($row, $number) {
            $row->column('number', $number+1);
        });
        $grid->column('name', '字段名');
        $grid->column('view', '小程序是否显示')->editable('select', [1 => '显示', -1 => '不显示']); 

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
        $show = new Show(CompanyExtraField::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', '字段名');
        $show->field('view', '是否显示');
        $show->field('created_at', __('Created at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CompanyExtraField());

        $form->text('name', '字段名');
        $form->switch('view', '是否显示')->default(1);

        return $form;
    }
}
