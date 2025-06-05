<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Table;
use App\Models\TagWord;
use App\Models\Search;
use App\Models\Company;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('统计分析')
            ->row(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $info = Search::select(DB::raw('id,word,count(word) as num'))->groupBy('word')->orderBy('num','desc')->limit(10)->get()->toArray();
                    foreach ($info as $k => $v) {
                        $info[$k]['persent'] = sprintf("%.2f",round($v['num']/Search::count()*100,2))."%";
                    }
                    $column->append('<h4>搜索词排行(全部)</h4>');
                    $headers = ['Id', '搜索词', '次数', '占比'];

                    $table = new Table($headers, $info);
                    $column->append($table->render());
                    $column->append('<style>.table{background-color:#ffffff}</style>');
                });

                $row->column(6, function (Column $column) {
                    $info = TagWord::select(DB::raw('id,word,count(word) as num'))->groupBy('word')->orderBy('num','desc')->limit(10)->get()->toArray();
                    foreach ($info as $k => $v) {
                        $info[$k]['persent'] = sprintf("%.2f",round($v['num']/TagWord::count()*100,2))."%";
                    }
                    $column->append('<h4>tag使用排行(全部)</h4>');
                    $headers = ['Id', 'tag词', '次数', '占比'];
                    $table = new Table($headers, $info);
                    $column->append($table->render());
                });
            })->row(function (Row $row) {

                
            });
    }
}
