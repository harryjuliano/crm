<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\OpportunityItemRequest;
use App\Models\Opportunity;
use App\Models\OpportunityItem;

class OpportunityItemController extends Controller
{
    public function index()
    {
        $opportunityItems = OpportunityItem::query()->with('opportunity:id,title')
            ->when(request('search'), fn ($query, $search) => $query->where('description', 'like', "%{$search}%"))
            ->latest()->paginate(10)->withQueryString();

        return inertia('Apps/OpportunityItems/Index', ['opportunityItems' => $opportunityItems]);
    }

    public function create()
    {
        return inertia('Apps/OpportunityItems/Create', [
            'opportunities' => Opportunity::select('id', 'title')->orderBy('title')->get(),
        ]);
    }

    public function store(OpportunityItemRequest $request)
    {
        OpportunityItem::create($request->validated());
        return to_route('apps.opportunity-items.index');
    }

    public function edit(OpportunityItem $opportunity_item)
    {
        return inertia('Apps/OpportunityItems/Edit', [
            'opportunityItem' => $opportunity_item,
            'opportunities' => Opportunity::select('id', 'title')->orderBy('title')->get(),
        ]);
    }

    public function update(OpportunityItemRequest $request, OpportunityItem $opportunity_item)
    {
        $opportunity_item->update($request->validated());
        return to_route('apps.opportunity-items.index');
    }

    public function destroy(OpportunityItem $opportunity_item)
    {
        $opportunity_item->delete();
        return back();
    }
}
