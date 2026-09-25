<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityHistory;
use App\Models\InventoryMovement;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class OperationalReportController extends Controller
{
    public function index(Request $request)
    {
        [$month, $year] = $this->period($request);

        $homestay = $this->buildAreaData(
            'homestay',
            $month,
            $year
        );

        $cafe = $this->buildAreaData(
            'cafe',
            $month,
            $year
        );

        $periodLabel = $this->periodLabel(
            $month,
            $year
        );

        return view(
            'admin.operational-reports.index',
            compact(
                'month',
                'year',
                'periodLabel',
                'homestay',
                'cafe'
            )
        );
    }


    public function homestay(Request $request)
    {
        return $this->download(
            $request,
            'homestay'
        );
    }


    public function cafe(Request $request)
    {
        return $this->download(
            $request,
            'cafe'
        );
    }


    private function download(
        Request $request,
        string $area
    ) {
        [$month, $year] = $this->period($request);

        $data = $this->buildAreaData(
            $area,
            $month,
            $year
        );

        $periodLabel = $this->periodLabel(
            $month,
            $year
        );

        $areaLabel = $area === 'homestay'
            ? 'Homestay'
            : 'Cafe & Resto';

        $reportCode = $area === 'homestay'
            ? "GN-OPS-HST-{$year}"
                . str_pad(
                    $month,
                    2,
                    '0',
                    STR_PAD_LEFT
                )
            : "GN-OPS-CAF-{$year}"
                . str_pad(
                    $month,
                    2,
                    '0',
                    STR_PAD_LEFT
                );

        $pdf = Pdf::loadView(
            'admin.operational-reports.pdf.area',
            compact(
                'month',
                'year',
                'periodLabel',
                'area',
                'areaLabel',
                'reportCode',
                'data'
            )
        )->setPaper(
            'a4',
            'portrait'
        );

        $filename = sprintf(
            'operational-report-%s-%04d-%02d.pdf',
            $area,
            $year,
            $month
        );

        return $pdf->download($filename);
    }


    private function buildAreaData(
        string $area,
        int $month,
        int $year
    ): array {
        $inventoryMovements =
            InventoryMovement::query()
                ->with('inventoryItem')
                ->whereHas(
                    'inventoryItem',
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
                ->orderBy('occurred_at')
                ->get();


        $facilityHistories =
            FacilityHistory::query()
                ->with('facilityAsset')
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
                ->orderBy('occurred_at')
                ->get();


        $inventoryByItem =
            $this->inventoryByItem(
                $inventoryMovements
            );


        return [
            'inventory_movements' =>
                $inventoryMovements,

            'facility_histories' =>
                $facilityHistories,

            'inventory_by_item' =>
                $inventoryByItem,

            'inventory' => [
                'transactions' =>
                    $inventoryMovements->count(),

                'stock_in_cost' =>
                    $this->movementCost(
                        $inventoryMovements,
                        ['STOCK_IN']
                    ),

                'used_cost' =>
                    $this->movementCost(
                        $inventoryMovements,
                        ['USED']
                    ),

                'damaged_cost' =>
                    $this->movementCost(
                        $inventoryMovements,
                        ['DAMAGED']
                    ),

                'lost_cost' =>
                    $this->movementCost(
                        $inventoryMovements,
                        ['LOST']
                    ),

                'adjustment_out_cost' =>
                    $this->movementCost(
                        $inventoryMovements,
                        ['ADJUSTMENT_OUT']
                    ),

                'operational_out_cost' =>
                    $this->movementCost(
                        $inventoryMovements,
                        [
                            'USED',
                            'DAMAGED',
                            'LOST',
                            'ADJUSTMENT_OUT',
                        ]
                    ),
            ],

            'facilities' => [
                'activities' =>
                    $facilityHistories->count(),

                'damaged' =>
                    $facilityHistories
                        ->where(
                            'activity_type',
                            'DAMAGED'
                        )
                        ->count(),

                'maintenance' =>
                    $facilityHistories
                        ->where(
                            'activity_type',
                            'MAINTENANCE'
                        )
                        ->count(),

                'repairs' =>
                    $facilityHistories
                        ->where(
                            'activity_type',
                            'REPAIR'
                        )
                        ->count(),

                'replacements' =>
                    $facilityHistories
                        ->where(
                            'activity_type',
                            'REPLACEMENT'
                        )
                        ->count(),

                'maintenance_cost' =>
                    $this->facilityCost(
                        $facilityHistories,
                        ['MAINTENANCE']
                    ),

                'repair_cost' =>
                    $this->facilityCost(
                        $facilityHistories,
                        ['REPAIR']
                    ),

                'replacement_cost' =>
                    $this->facilityCost(
                        $facilityHistories,
                        ['REPLACEMENT']
                    ),

                'total_cost' =>
                    (float) $facilityHistories
                        ->sum('cost'),
            ],
        ];
    }


    private function inventoryByItem(
        Collection $movements
    ): Collection {
        return $movements
            ->groupBy('inventory_item_id')
            ->map(function ($rows) {
                $item = $rows
                    ->first()
                    ->inventoryItem;

                return [
                    'item' => $item,

                    'stock_in' =>
                        (float) $rows
                            ->where(
                                'movement_type',
                                'STOCK_IN'
                            )
                            ->sum('quantity'),

                    'used' =>
                        (float) $rows
                            ->where(
                                'movement_type',
                                'USED'
                            )
                            ->sum('quantity'),

                    'damaged' =>
                        (float) $rows
                            ->where(
                                'movement_type',
                                'DAMAGED'
                            )
                            ->sum('quantity'),

                    'lost' =>
                        (float) $rows
                            ->where(
                                'movement_type',
                                'LOST'
                            )
                            ->sum('quantity'),

                    'returned' =>
                        (float) $rows
                            ->where(
                                'movement_type',
                                'RETURNED'
                            )
                            ->sum('quantity'),

                    'adjustment_in' =>
                        (float) $rows
                            ->where(
                                'movement_type',
                                'ADJUSTMENT_IN'
                            )
                            ->sum('quantity'),

                    'adjustment_out' =>
                        (float) $rows
                            ->where(
                                'movement_type',
                                'ADJUSTMENT_OUT'
                            )
                            ->sum('quantity'),

                    'cost' =>
                        (float) $rows
                            ->whereIn(
                                'movement_type',
                                [
                                    'USED',
                                    'DAMAGED',
                                    'LOST',
                                    'ADJUSTMENT_OUT',
                                ]
                            )
                            ->sum('total_cost'),
                ];
            })
            ->values();
    }


    private function movementCost(
        Collection $movements,
        array $types
    ): float {
        return (float) $movements
            ->whereIn(
                'movement_type',
                $types
            )
            ->sum('total_cost');
    }


    private function facilityCost(
        Collection $histories,
        array $types
    ): float {
        return (float) $histories
            ->whereIn(
                'activity_type',
                $types
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
