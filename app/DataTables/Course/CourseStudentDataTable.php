<?php

namespace App\DataTables\Course;


use App\Models\Backend\Course\Course;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\CollectionDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CourseStudentDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query)
    {

//        return (new EloquentDataTable($query))
        return (new CollectionDataTable(Course::find(1)->students))->toJson();
//            ->addColumn('name', function ($student){
//                return $student->user->name;
//            })
//            ->addColumn('mobile', function ($student){
//                return $student->user->mobile;
//            })
//            ->addColumn('status', function ($student){
//                return $student->status == 1 ? 'Active' : 'Inactive';
//            })
//            ->addColumn('action', function ($student){
//                $btn = '';
//                $btn    = '<form class="d-inline" action="'.route("detach-student", $this->course->id) .'" method="post" onsubmit="return confirm(\'Are you sure to Detach this Student from this course?\')">
//                                                    <input type="hidden" name="_token" value="'. csrf_token() .'">
//                                                    <input type="hidden" name="student_id" value="'.$student->id.'">
//                                                    <button type="submit" class="btn btn-sm btn-danger" title="Detach Student from this Course?">
//                                                        <i class="fa-solid fa-trash"></i>
//                                                    </button>
//                                                </form>';
//                return $btn;
//            })
//            ->rawColumns(['name', 'mobile', 'status', 'action'])
//            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Course $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('coursestudent-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
//                        Button::make('reset'),
//                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('mobile'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
//                  ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CourseStudent_' . date('YmdHis');
    }
}
