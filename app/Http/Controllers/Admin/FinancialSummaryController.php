<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\FacilityHistory;
use App\Models\InventoryMovement;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FinancialSummaryController extends Controller
{
    public function index(Request $request)
    {
        [$month, $year] = $this->period($request);

        $summary = $this->buildSummary(
            $month,
            $year
        );

        $periodLabel = $this->periodLabel(
            $month,
            $year
        );

        return view(
            'admin.financial-summary.index',
            compact(
                'month',
                'year',
                'periodLabel',
                'summary'
            )
        );
    }


    public function download(Request $request)
    {
        [$month, $year] = $this->period($request);

        $summary = $this->buildSummary(
            $month,
            $year
        );

        $periodLabel = $this->periodLabel(
            $month,
            $year
        );

        $reportCode =
            'GN-FIN-'
            . $year
            . str_pad(
                $month,
                2,
                '0',
                STR_PAD_LEFT
            );

        $pdf = Pdf::loadView(
            'admin.financial-summary.pdf.summary',
            compact(
                'month',
                'year',
                'periodLabel',
                'reportCode',
                'summary'
            )
        )->setPaper(
            'a4',
            'portrait'
        );

        return $pdf->download(
            sprintf(
                'financial-summary-%04d-%02d.pdf',
                $year,
                $month
            )
        );
    }


    private function buildSummary(
        int $month,
        int $year
    ): array {
        $homestayRevenue = (float) Booking::query()
            ->where(
                'payment_status',
                'paid'
            )
            ->whereNotNull('paid_at')
            ->whereYear(
                'paid_at',
                $year
            )
            ->whereMonth(
                'paid_at',
                $month
            )
            ->sum('total_price');


        $cafeRevenue = (float) Order::query()
            ->where(
                'payment_status',
                'paid'
            )
            ->whereNotNull('paid_at')
            ->whereYear(
                'paid_at',
                $year
            )
            ->whereMonth(
                'paid_at',
                $month
            )
            ->sum('subtotal');


        $homestayInventoryCost =
            $this->inventoryCost(
                'homestay',
                $month,
                $year
            );

        $cafeInventoryCost =
            $this->inventoryCost(
                'cafe',
                $month,
                $year
            );


        $homestayFacilityCost =
            $this->facilityCost(
                'homestay',
                $month,
                $year
            );

        $cafeFacilityCost =
            $this->facilityCost(
                'cafe',
                $month,
                $year
            );


        $homestayOperationalCost =
            $homestayInventoryCost
            + $homestayFacilityCost;

        $cafeOperationalCost =
            $cafeInventoryCost
            + $cafeFacilityCost;


        $homestaySurplus =
            $homestayRevenue
            - $homestayOperationalCost;

        $cafeSurplus =
            $cafeRevenue
            - $cafeOperationalCost;


        $totalRevenue =
            $homestayRevenue
            + $cafeRevenue;

        $totalOperationalCost =
            $homestayOperationalCost
            + $cafeOperationalCost;

        $totalSurplus =
            $totalRevenue
            - $totalOperationalCost;


        return [
            'homestay' => [
                'revenue' =>
                    $homestayRevenue,

                'inventory_cost' =>
                    $homestayInventoryCost,

                'facility_cost' =>
                    $homestayFacilityCost,

                'operational_cost' =>
                    $homestayOperationalCost,

                'surplus' =>
                    $homestaySurplus,
            ],

            'cafe' => [
                'revenue' =>
                    $cafeRevenue,

                'inventory_cost' =>
                    $cafeInventoryCost,

                'facility_cost' =>
                    $cafeFacilityCost,

                'operational_cost' =>
                    $cafeOperationalCost,

                'surplus' =>
                    $cafeSurplus,
            ],

            'total' => [
                'revenue' =>
                    $totalRevenue,

                'operational_cost' =>
                    $totalOperationalCost,

                'surplus' =>
                    $totalSurplus,
            ],
        ];
    }


    private function inventoryCost(
        string $area,
        int $month,
        int $year
    ): float {
        return (float) InventoryMovement::query()
            ->whereHas(
                'inventoryItem',
                fn ($query) =>
                    $query->where(
                        'area',
                        $area
                    )
            )
            ->whereIn(
                'movement_type',
                [
                    'USED',
                    'DAMAGED',
                    'LOST',
                    'ADJUSTMENT_OUT',
                ]
            )
            ->whereYear(
                'occurred_at',
                $year
            )
            ->whereMonth(
                'occurred_at',
                $month
            )
            ->sum('total_cost');
    }


    private function facilityCost(
        string $area,
        int $month,
        int $year
    ): float {
        return (float) FacilityHistory::query()
            ->whereHas(
                'facilityAsset',
                fn ($query) =>
                    $query->where(
                        'area',
                        $area
                    )
            )
            ->whereYear(
                'occurred_at',
                $year
            )
            ->whereMonth(
                'occurred_at',
                $month
            )
            ->sum('cost');
    }


    private function period(
        Request $request
    ): array {
        $month = (int) $request->input(
            'month',
            now()->month
        );

        $year = (int) $request->input(
            'year',
            now()->year
        );

        abort_unless(
            $month >= 1
            && $month <= 12
            && $year >= 2020
            && $year <= 2100,
            422,
            'Periode laporan tidak valid.'
        );

        return [
            $month,
            $year,
        ];
    }


    private function periodLabel(
        int $month,
        int $year
    ): string {
        return Carbon::create(
            $year,
            $month,
            1
        )
            ->locale('id')
            ->translatedFormat('F Y');
    }
}
