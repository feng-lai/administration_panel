<?php

namespace App\Admin\Controllers;

use App\Models\TagWord;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class TagWordController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Tag词排行分析';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TagWord());

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->like('word', 'tag词');
            // 在这里添加字段过滤器
            $filter->between('created_at','时间')->datetime();

        });

        $grid->number('序号');
        $grid->rows(function ($row, $number) {
            $row->column('number', $number+1);
        });
        $grid->model()->select(DB::raw('count(word) as num,word,id'))->groupBy('word')->orderBy('num','desc');
        $grid->column('word', __('Word'));
        $grid->column('num', __('Num'))->display(function(){
            return TagWord::where('word',$this->word)->count();
        });
        $grid->column('persent', __('Persent'))->display(function(){
            $all = TagWord::count();
            $word = TagWord::where('word',$this->word)->count();
            return sprintf("%.2f",round(($word/$all)*100,2))."%";
        });
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
        $show = new Show(TagWord::findOrFail($id));

        $show->field('word', __('Word'));
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
        $form = new Form(new TagWord());
        $form->text('word', __('Word'));

        return $form;
    }
}
