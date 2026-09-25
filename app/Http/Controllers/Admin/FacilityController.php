<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacilityAsset;
use App\Models\FacilityHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $assets = FacilityAsset::query()
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = $request->search;

                    $query->where(
                        function ($query) use ($search) {
                            $query
                                ->where(
                                    'asset_code',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'location',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'brand',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )
            ->when(
                $request->filled('area'),
                fn ($query) =>
                    $query->where(
                        'area',
                        $request->area
                    )
            )
            ->when(
                $request->filled('condition'),
                fn ($query) =>
                    $query->where(
                        'condition',
                        $request->condition
                    )
            )
            ->when(
                $request->boolean('attention'),
                fn ($query) =>
                    $query->needsAttention()
            )
            ->orderBy('area')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();


        $stats = [
            'total' => FacilityAsset::where(
                'is_active',
                true
            )->count(),

            'homestay' => FacilityAsset::where(
                'is_active',
                true
            )
                ->where('area', 'homestay')
                ->count(),

            'cafe' => FacilityAsset::where(
                'is_active',
                true
            )
                ->where('area', 'cafe')
                ->count(),

            'attention' => FacilityAsset::where(
                'is_active',
                true
            )
                ->needsAttention()
                ->count(),

            'maintenance_due' => FacilityAsset::where(
                'is_active',
                true
            )
                ->maintenanceDue()
                ->count(),
        ];


        return view(
            'admin.facilities.index',
            compact(
                'assets',
                'stats'
            )
        );
    }


    public function create()
    {
        return view(
            'admin.facilities.create'
        );
    }


    public function store(Request $request)
    {
        $validated = $this->validateAsset(
            $request
        );

        /*
         * Harga aset merupakan informasi owner.
         */
        if (!auth()->user()?->isOwner()) {
            unset($validated['purchase_price']);
        }

        $validated['asset_code'] =
            $this->generateAssetCode(
                $validated['area']
            );

        $validated['is_active'] =
            $request->boolean('is_active');

        $asset = FacilityAsset::create(
            $validated
        );


        FacilityHistory::create([
            'facility_asset_id' =>
                $asset->id,

            'user_id' =>
                auth()->id(),

            'activity_type' =>
                'INSPECTION',

            'condition_before' =>
                null,

            'condition_after' =>
                $asset->condition,

            'notes' =>
                'Aset pertama kali didaftarkan.',

            'occurred_at' =>
                now(),
        ]);


        return redirect(
            route(
                'admin.facilities.index',
                [],
                false
            )
        )->with(
            'success',
            'Fasilitas berhasil ditambahkan.'
        );
    }


    public function edit(
        FacilityAsset $facilityAsset
    ) {
        return view(
            'admin.facilities.edit',
            compact('facilityAsset')
        );
    }


    public function update(
        Request $request,
        FacilityAsset $facilityAsset
    ) {
        $validated = $this->validateAsset(
            $request
        );

        /*
         * Receptionist tidak boleh melihat atau
         * mengubah harga pembelian aset.
         */
        if (!auth()->user()?->isOwner()) {
            unset($validated['purchase_price']);
        }

        $validated['is_active'] =
            $request->boolean('is_active');

        /*
         * Condition dan status operasional tidak boleh
         * diubah langsung dari halaman edit.
         */
        unset($validated['condition']);
        unset($validated['status']);

        $facilityAsset->update(
            $validated
        );

        return redirect(
            route(
                'admin.facilities.index',
                [],
                false
            )
        )->with(
            'success',
            'Data fasilitas berhasil diperbarui.'
        );
    }


    public function histories(
        FacilityAsset $facilityAsset
    ) {
        $histories = $facilityAsset
            ->histories()
            ->with('user')
            ->latest('occurred_at')
            ->paginate(20);

        return view(
            'admin.facilities.histories',
            compact(
                'facilityAsset',
                'histories'
            )
        );
    }


    public function storeHistory(
        Request $request,
        FacilityAsset $facilityAsset
    ) {
        $validated = $request->validate([
            'activity_type' => [
                'required',
                Rule::in([
                    'INSPECTION',
                    'DAMAGED',
                    'MAINTENANCE',
                    'REPAIR',
                    'REPLACEMENT',
                    'RETIREMENT',
                ]),
            ],

            'condition_after' => [
                'nullable',
                Rule::in([
                    'good',
                    'needs_maintenance',
                    'damaged',
                    'under_repair',
                    'replaced',
                    'retired',
                ]),
            ],

            'cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'vendor' => [
                'nullable',
                'string',
                'max:255',
            ],

            'reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'occurred_at' => [
                'nullable',
                'date',
            ],

            'next_maintenance_at' => [
                'nullable',
                'date',
            ],
        ]);


        /*
         * Biaya maintenance/repair merupakan
         * informasi finansial owner.
         */
        if (!auth()->user()?->isOwner()) {
            unset($validated['cost']);
        }

        DB::transaction(function () use (
            $validated,
            $facilityAsset
        ) {
            $asset = FacilityAsset::query()
                ->lockForUpdate()
                ->findOrFail(
                    $facilityAsset->id
                );

            $conditionBefore =
                $asset->condition;

            $conditionAfter =
                $this->resolveCondition(
                    $validated[
                        'activity_type'
                    ],
                    $validated[
                        'condition_after'
                    ] ?? null,
                    $conditionBefore
                );


            FacilityHistory::create([
                'facility_asset_id' =>
                    $asset->id,

                'user_id' =>
                    auth()->id(),

                'activity_type' =>
                    $validated[
                        'activity_type'
                    ],

                'condition_before' =>
                    $conditionBefore,

                'condition_after' =>
                    $conditionAfter,

                'cost' =>
                    $validated['cost']
                    ?? null,

                'vendor' =>
                    $validated['vendor']
                    ?? null,

                'reference' =>
                    $validated['reference']
                    ?? null,

                'notes' =>
                    $validated['notes']
                    ?? null,

                'occurred_at' =>
                    $validated['occurred_at']
                    ?? now(),
            ]);


            $asset->condition =
                $conditionAfter;


            if (
                in_array(
                    $validated['activity_type'],
                    [
                        'MAINTENANCE',
                        'REPAIR',
                    ],
                    true
                )
            ) {
                $asset->last_maintenance_at =
                    now()->toDateString();
            }


            if (
                isset(
                    $validated[
                        'next_maintenance_at'
                    ]
                )
            ) {
                $asset->next_maintenance_at =
                    $validated[
                        'next_maintenance_at'
                    ];
            }


            if (
                $validated['activity_type']
                === 'REPLACEMENT'
            ) {
                $asset->status =
                    'replaced';

                $asset->is_active =
                    false;
            }


            if (
                $validated['activity_type']
                === 'RETIREMENT'
            ) {
                $asset->status =
                    'retired';

                $asset->is_active =
                    false;
            }


            $asset->save();
        });


        return back()->with(
            'success',
            'Riwayat fasilitas berhasil dicatat.'
        );
    }


    public function updateHistoryCost(
        Request $request,
        FacilityAsset $facilityAsset,
        FacilityHistory $history
    ) {
        /*
         * Pastikan history benar-benar milik
         * facility yang ada pada URL.
         */
        abort_unless(
            $history->facility_asset_id
                === $facilityAsset->id,
            404
        );

        $validated = $request->validate([
            'cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        $history->update([
            'cost' =>
                $validated['cost'] ?? null,
        ]);

        return back()->with(
            'success',
            'Biaya aktivitas fasilitas berhasil diperbarui.'
        );
    }


    private function validateAsset(
        Request $request
    ): array {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'area' => [
                'required',
                Rule::in([
                    'homestay',
                    'cafe',
                ]),
            ],

            'category' => [
                'nullable',
                'string',
                'max:255',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'condition' => [
                'required',
                Rule::in([
                    'good',
                    'needs_maintenance',
                    'damaged',
                    'under_repair',
                    'replaced',
                    'retired',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'replaced',
                    'retired',
                ]),
            ],

            'brand' => [
                'nullable',
                'string',
                'max:255',
            ],

            'model' => [
                'nullable',
                'string',
                'max:255',
            ],

            'serial_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'purchase_date' => [
                'nullable',
                'date',
            ],

            'purchase_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'last_maintenance_at' => [
                'nullable',
                'date',
            ],

            'next_maintenance_at' => [
                'nullable',
                'date',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);
    }


    private function resolveCondition(
        string $activity,
        ?string $requestedCondition,
        string $currentCondition
    ): string {
        return match ($activity) {
            'DAMAGED' =>
                'damaged',

            'MAINTENANCE' =>
                'under_repair',

            'REPAIR' =>
                'good',

            'REPLACEMENT' =>
                'replaced',

            'RETIREMENT' =>
                'retired',

            'INSPECTION' =>
                $requestedCondition
                    ?? $currentCondition,

            default =>
                $requestedCondition
                    ?? $currentCondition,
        };
    }


    private function generateAssetCode(
        string $area
    ): string {
        $prefix = $area === 'homestay'
            ? 'FAC-HST'
            : 'FAC-CAF';

        do {
            $code =
                $prefix
                . '-'
                . strtoupper(
                    Str::random(6)
                );
        } while (
            FacilityAsset::where(
                'asset_code',
                $code
            )->exists()
        );

        return $code;
    }
}
