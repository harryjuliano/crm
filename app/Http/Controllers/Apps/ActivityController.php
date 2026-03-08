<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Models\Activity;
use App\Models\Customer;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\User;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::query()->with('user:id,name')
            ->when(request('search'), fn ($query, $search) => $query->where('subject', 'like', "%{$search}%"))
            ->latest()->paginate(10)->withQueryString();

        return inertia('Apps/Activities/Index', ['activities' => $activities]);
    }

    public function create()
    {
        return inertia('Apps/Activities/Create', [
            'users' => User::select('id', 'name')->orderBy('name')->get(),
            'relatables' => $this->relatables(),
        ]);
    }

    public function store(ActivityRequest $request)
    {
        Activity::create($request->validated());
        return to_route('apps.activities.index');
    }

    public function edit(Activity $activity)
    {
        return inertia('Apps/Activities/Edit', [
            'activity' => $activity,
            'users' => User::select('id', 'name')->orderBy('name')->get(),
            'relatables' => $this->relatables(),
        ]);
    }

    public function update(ActivityRequest $request, Activity $activity)
    {
        $activity->update($request->validated());
        return to_route('apps.activities.index');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return back();
    }

    private function relatables(): array
    {
        return [
            'App\\Models\\Lead' => Lead::select('id', 'name')->orderBy('name')->get(),
            'App\\Models\\Opportunity' => Opportunity::select('id', 'title as name')->orderBy('title')->get(),
            'App\\Models\\Customer' => Customer::select('id', 'name')->orderBy('name')->get(),
        ];
    }
}
