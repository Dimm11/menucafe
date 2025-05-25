<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    protected $salesData;

    public function __construct(Collection $salesData)
    {
        $this->salesData = $salesData;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->salesData->map(function($detail) {
            return [
                'Order ID' => $detail->order_id,
                'Order Date' => (new \DateTime($detail->order_date))->format('Y-m-d H:i:s'),
                'Payment Method' => $detail->metode_pembayaran,
                'Product Name' => $detail->product_name,
                'Quantity' => $detail->qty,
                'Subtotal' => $detail->sub_total,
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Order ID',
            'Order Date',
            'Payment Method',
            'Product Name',
            'Quantity',
            'Subtotal',
        ];
    }

    /**
     * @return array
     */
    public function footers(): array
    {
        $totalSales = $this->salesData->sum('sub_total');

        return [
            ['', '', '', '', 'Total Sales', $totalSales]
        ];
    }
}
