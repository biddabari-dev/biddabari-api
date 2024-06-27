<?php

namespace App\DataTables\ParentOrderDataTable;

use App\Models\Backend\OrderManagement\ParentOrder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AllOrders extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($allOrder){
                $btn = '';
                $btn .= '<a href="" data-order-id="'. $allOrder->id .'" class="btn btn-sm show-order-details btn-warning mt-1" title="Change Order Status"><i class="fa-solid fa-print"></i></a>';
                $btn .= '<form class="d-inline" action="'. route('course-orders.destroy', $allOrder->id).'" method="post" ><input type="hidden" name="_token" value="'.csrf_token().'" /><input type="hidden" name="_method" value="delete" /><button type="submit" class="btn btn-sm btn-danger data-delete-form ms-2"><i class="fa-solid fa-trash"></i></button></form>';
                return $btn;
            })
            ->addColumn('student_name', function ($allOrder){
                return $allOrder->user->name;
            })
            ->addColumn('ordered_for', function ($allOrder){

                if ($allOrder->ordered_for == 'course')
                {
                    return $allOrder->course->title;
                } elseif ($allOrder->ordered_for == 'batch_exam')
                {
                    return $allOrder->batchExam->title;
                } elseif ($allOrder->ordered_for == 'product')
                {
                    return $allOrder->product->title;
                } else {
                    return '';
                }
            })->addColumn('payment', function ($allOrder){
                $p = '';
                $p .= 'Total: '. $allOrder->total_amount .'<br/>';
                $p .= 'Paid: '. $allOrder->paid_amount ?? 0 .'<br/>';
                $p .= 'Due: '. $allOrder->total_amount - $allOrder->paid_amount ;
                return $p;
            })
            ->addColumn('payment_info', function ($allOrder){
                return 'F- '. $allOrder->paid_from .' <br/> T- '. $allOrder->paid_to .' <br> V- '. $allOrder->vendor;
            })
            ->addColumn('created_at', function ($allOrder){
                return $allOrder->created_at->format('d M, Y');
            })
            ->addColumn('status', function ($allOrder){
                return '<a href="javascript:void(0)" class="badge bg-primary m-1">Payment '. $allOrder->payment_status .'</a><br><a href="javascript:void(0)" class="badge bg-primary m-1">Order '.$allOrder->status .' ';
            })
            ->orderColumn('id', 'DESC')
            ->rawColumns(['action', 'student_name', 'ordered_for', 'payment', 'payment_info', 'created_at', 'status'])
            ->order(function ($q) {
                $q->orderBy('id', 'desc');
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ParentOrder $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('allorders-table')
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
            Column::make('order_invoice_number')->searchable(true)->title('Order No.'),
            Column::make('ordered_for')->searchable(true)->title('Title'),
            Column::make('student_name')->searchable(true)->title('S. Name'),
            Column::make('payment')->searchable(true),
            Column::make('payment_info')->searchable(true),
            Column::make('txt_id')->searchable(true),
            Column::make('created_at')->title('Enroll Date'),
            Column::make('status')->title('Payment & Contact Status'),
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
        return 'AllOrders_' . date('YmdHis');
    }
}
