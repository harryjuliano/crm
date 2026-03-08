<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Models\Lead;
use App\Models\LeadSource;
use App\Models\User;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::query()->with(['source:id,name', 'assignee:id,name'])
            ->when(request('search'), fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->latest()->paginate(10)->withQueryString();

        return inertia('Apps/Leads/Index', ['leads' => $leads]);
    }

    public function create()
    {
        return inertia('Apps/Leads/Create', [
            'leadSources' => LeadSource::select('id', 'name')->orderBy('name')->get(),
            'users' => User::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function store(LeadRequest $request)
    {
        Lead::create($request->validated());
        return to_route('apps.leads.index');
    }

    public function edit(Lead $lead)
    {
        return inertia('Apps/Leads/Edit', [
            'lead' => $lead,
            'leadSources' => LeadSource::select('id', 'name')->orderBy('name')->get(),
            'users' => User::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(LeadRequest $request, Lead $lead)
    {
        $lead->update($request->validated());
        return to_route('apps.leads.index');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return back();
    }
}
