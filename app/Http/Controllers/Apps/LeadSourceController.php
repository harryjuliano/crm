<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadSourceRequest;
use App\Models\LeadSource;

class LeadSourceController extends Controller
{
    public function index()
    {
        $leadSources = LeadSource::query()->when(request('search'), fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->latest()->paginate(10)->withQueryString();

        return inertia('Apps/LeadSources/Index', ['leadSources' => $leadSources]);
    }

    public function create()
    {
        return inertia('Apps/LeadSources/Create');
    }

    public function store(LeadSourceRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        LeadSource::create($data);

        return to_route('apps.lead-sources.index');
    }

    public function edit(LeadSource $lead_source)
    {
        return inertia('Apps/LeadSources/Edit', ['leadSource' => $lead_source]);
    }

    public function update(LeadSourceRequest $request, LeadSource $lead_source)
    {
        $data = $request->validated();
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $lead_source->update($data);

        return to_route('apps.lead-sources.index');
    }

    public function destroy(LeadSource $lead_source)
    {
        $lead_source->delete();
        return back();
    }
}
