<?php

namespace App\DataTables\UserDataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class Users extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
//            ->addColumn('id', function ($user){
//                return ++$this->dataTableCounter;
//            })
            ->addColumn('action', function ($user){
                $btn = '';
                $btn .= '<a href="'.route("users.edit", $user->id) .'" class="btn btn-sm btn-warning"><i class="fa-solid fa-edit"></i></a>';
                $btn .= '<form class="d-inline" action="'. route('users.destroy', $user->id).'" method="post" ><input type="hidden" name="_token" value="'.csrf_token().'" /><input type="hidden" name="_method" value="delete" /><button type="submit" class="btn btn-sm btn-danger data-delete-form ms-2"><i class="fa-solid fa-trash"></i></button></form>';
                return $btn;
            })
            ->addColumn('roles', function($user){
                $span = '';
                foreach ($user->roles as $role)
                {
                    $span   .= '<p class="badge bg-primary">'. $role->title .'</p>';
                }
                return $span;
            })
            ->addColumn('status', function ($user){
                return $user->status == 1 ? 'Active' : 'Inactive';
            })
            ->orderColumn('id', 'DESC')
            ->rawColumns(['action', 'roles'])
            ->order(function ($q){
                $q->orderBy('id', 'desc');
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
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

            Column::make('id')->title('#')->exportable(true)->printable(true)->orderable(true),
            Column::make('name')->searchable(true),
            Column::make('mobile'),
            Column::computed('roles')->exportable(true)->printable(true)->addClass('text-center'),
            Column::make('status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
//                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
