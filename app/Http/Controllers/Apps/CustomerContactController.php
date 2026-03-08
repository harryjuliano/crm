<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerContactRequest;
use App\Models\Customer;
use App\Models\CustomerContact;

class CustomerContactController extends Controller
{
    public function index()
    {
        $customerContacts = CustomerContact::query()->with('customer:id,name')
            ->when(request('search'), fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->latest()->paginate(10)->withQueryString();

        return inertia('Apps/CustomerContacts/Index', ['customerContacts' => $customerContacts]);
    }

    public function create()
    {
        return inertia('Apps/CustomerContacts/Create', ['customers' => Customer::select('id', 'name')->orderBy('name')->get()]);
    }

    public function store(CustomerContactRequest $request)
    {
        $data = $request->validated();
        $data['is_primary'] = (bool) ($data['is_primary'] ?? false);
        CustomerContact::create($data);

        return to_route('apps.customer-contacts.index');
    }

    public function edit(CustomerContact $customer_contact)
    {
        return inertia('Apps/CustomerContacts/Edit', [
            'customerContact' => $customer_contact,
            'customers' => Customer::select('id', 'name')->orderBy('name')->get(),
        ]);
    }

    public function update(CustomerContactRequest $request, CustomerContact $customer_contact)
    {
        $data = $request->validated();
        $data['is_primary'] = (bool) ($data['is_primary'] ?? false);
        $customer_contact->update($data);

        return to_route('apps.customer-contacts.index');
    }

    public function destroy(CustomerContact $customer_contact)
    {
        $customer_contact->delete();
        return back();
    }
}
