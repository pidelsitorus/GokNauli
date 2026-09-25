<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StatementController extends Controller
{
    public function index(Request $request)
    {
        $month = (int) $request->get(
            'month',
            now()->month
        );

        $year = (int) $request->get(
            'year',
            now()->year
        );

        $homestayRevenue = Booking::where(
            'payment_status',
            'paid'
        )
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->sum('total_price');

        $homestayTransactions = Booking::where(
            'payment_status',
            'paid'
        )
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->count();


        $cafeRevenue = Order::where(
            'payment_status',
            'paid'
        )
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->sum('subtotal');

        $cafeTransactions = Order::where(
            'payment_status',
            'paid'
        )
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->count();


        return view(
            'admin.statements.index',
            compact(
                'month',
                'year',
                'homestayRevenue',
                'homestayTransactions',
                'cafeRevenue',
                'cafeTransactions'
            )
        );
    }


    public function homestay(Request $request)
    {
        [$month, $year] = $this->period($request);

        $bookings = Booking::with([
            'room.roomType',
        ])
            ->where('payment_status', 'paid')
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->orderBy('paid_at')
            ->get();

        $totalRevenue = $bookings->sum(
            'total_price'
        );

        $pdf = Pdf::loadView(
            'admin.statements.pdf.homestay',
            compact(
                'bookings',
                'month',
                'year',
                'totalRevenue'
            )
        )->setPaper('a4', 'portrait');

        return $pdf->download(
            sprintf(
                'statement-homestay-%04d-%02d.pdf',
                $year,
                $month
            )
        );
    }


    public function cafe(Request $request)
    {
        [$month, $year] = $this->period($request);

        $orders = Order::with([
            'restaurantTable',
            'items',
        ])
            ->where('payment_status', 'paid')
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->orderBy('paid_at')
            ->get();

        $totalRevenue = $orders->sum(
            'subtotal'
        );

        $pdf = Pdf::loadView(
            'admin.statements.pdf.cafe',
            compact(
                'orders',
                'month',
                'year',
                'totalRevenue'
            )
        )->setPaper('a4', 'portrait');

        return $pdf->download(
            sprintf(
                'statement-cafe-resto-%04d-%02d.pdf',
                $year,
                $month
            )
        );
    }


    private function period(Request $request): array
    {
        $validated = $request->validate([
            'month' => [
                'required',
                'integer',
                'between:1,12',
            ],

            'year' => [
                'required',
                'integer',
                'between:2020,2100',
            ],
        ]);

        return [
            (int) $validated['month'],
            (int) $validated['year'],
        ];
    }
}
