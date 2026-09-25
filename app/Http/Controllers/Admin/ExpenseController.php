<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
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
            'Periode tidak valid.'
        );

        $expenses = Expense::query()
            ->with('user')
            ->whereYear(
                'expense_date',
                $year
            )
            ->whereMonth(
                'expense_date',
                $month
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
                $request->filled('category'),
                fn ($query) =>
                    $query->where(
                        'category',
                        $request->category
                    )
            )
            ->latest('expense_date')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $baseQuery = Expense::query()
            ->whereYear(
                'expense_date',
                $year
            )
            ->whereMonth(
                'expense_date',
                $month
            );

        $stats = [
            'total' =>
                (float) (clone $baseQuery)
                    ->sum('amount'),

            'general' =>
                (float) (clone $baseQuery)
                    ->where('area', 'general')
                    ->sum('amount'),

            'homestay' =>
                (float) (clone $baseQuery)
                    ->where('area', 'homestay')
                    ->sum('amount'),

            'cafe' =>
                (float) (clone $baseQuery)
                    ->where('area', 'cafe')
                    ->sum('amount'),
        ];

        return view(
            'admin.expenses.index',
            compact(
                'expenses',
                'stats',
                'month',
                'year'
            )
        );
    }


    public function create()
    {
        return view(
            'admin.expenses.create'
        );
    }


    public function store(Request $request)
    {
        $validated =
            $this->validateExpense($request);

        $validated['user_id'] =
            auth()->id();

        Expense::create($validated);

        return redirect(
            route(
                'admin.expenses.index',
                [],
                false
            )
        )->with(
            'success',
            'Pengeluaran berhasil dicatat.'
        );
    }


    public function edit(Expense $expense)
    {
        return view(
            'admin.expenses.edit',
            compact('expense')
        );
    }


    public function update(
        Request $request,
        Expense $expense
    ) {
        $validated =
            $this->validateExpense($request);

        $expense->update($validated);

        return redirect(
            route(
                'admin.expenses.index',
                [],
                false
            )
        )->with(
            'success',
            'Pengeluaran berhasil diperbarui.'
        );
    }


    public function destroy(
        Expense $expense
    ) {
        $expense->delete();

        return redirect(
            route(
                'admin.expenses.index',
                [],
                false
            )
        )->with(
            'success',
            'Pengeluaran berhasil dihapus.'
        );
    }


    private function validateExpense(
        Request $request
    ): array {
        return $request->validate([
            'area' => [
                'required',
                Rule::in([
                    'general',
                    'homestay',
                    'cafe',
                ]),
            ],

            'category' => [
                'required',
                Rule::in([
                    'electricity',
                    'water',
                    'internet',
                    'salary',
                    'tax',
                    'transport',
                    'office_supplies',
                    'marketing',
                    'rent',
                    'bank_fee',
                    'other',
                ]),
            ],

            'description' => [
                'required',
                'string',
                'max:255',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'expense_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'nullable',
                'string',
                'max:50',
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
        ]);
    }
}
