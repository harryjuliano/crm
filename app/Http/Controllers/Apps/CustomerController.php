<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()
            ->when(request('search'), fn ($query, $search) => $query->where('name', 'like', "%{$search}%")->orWhere('customer_code', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return inertia('Apps/Customers/Index', ['customers' => $customers]);
    }

    public function create()
    {
        return inertia('Apps/Customers/Create');
    }

    public function store(CustomerRequest $request)
    {
        Customer::create($request->validated());
        return to_route('apps.customers.index');
    }

    public function edit(Customer $customer)
    {
        return inertia('Apps/Customers/Edit', ['customer' => $customer]);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return to_route('apps.customers.index');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back();
    }
}
