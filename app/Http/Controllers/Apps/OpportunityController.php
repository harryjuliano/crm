<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\OpportunityRequest;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\User;

class OpportunityController extends Controller
{
    public function index()
    {
        $opportunities = Opportunity::query()->with(['lead:id,name', 'customer:id,name', 'assignee:id,name'])
            ->when(request('search'), fn ($query, $search) => $query->where('title', 'like', "%{$search}%"))
            ->latest()->paginate(10)->withQueryString();

        return inertia('Apps/Opportunities/Index', ['opportunities' => $opportunities]);
    }

    public function create()
    {
        return inertia('Apps/Opportunities/Create', [
            'leads' => Lead::select('id', 'name')->orderBy('name')->get(),
            'customers' => Customer::select('id', 'name')->orderBy('name')->get(),
            'users' => User::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(OpportunityRequest $request)
    {
        Opportunity::create($request->validated());
        return to_route('apps.opportunities.index');
    }

    public function edit(Opportunity $opportunity)
    {
        return inertia('Apps/Opportunities/Edit', [
            'opportunity' => $opportunity,
            'leads' => Lead::select('id', 'name')->orderBy('name')->get(),
            'customers' => Customer::select('id', 'name')->orderBy('name')->get(),
            'users' => User::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(OpportunityRequest $request, Opportunity $opportunity)
    {
        $opportunity->update($request->validated());
        return to_route('apps.opportunities.index');
    }

    public function destroy(Opportunity $opportunity)
    {
        $opportunity->delete();
        return back();
    }
}
