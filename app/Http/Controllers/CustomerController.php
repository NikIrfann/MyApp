<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $data = Customer::where('name', 'LIKE', '%' . $request->search . '%')->paginate(10);
        } else {
            $data = Customer::paginate(10);
        }

        return view('customerList', compact('data'));
    }

    public function customerAdd()
    {
        return view('customerAdd');
    }

    public function insertNewCustomer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kg' => 'required|integer',
            'phoneno' => 'required|string|max:15',
            'pickuptime' => 'required|string',
            'date' => 'required|date_format:d/m/Y',
        ]);

        try {
            $formattedDate = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
            $formattedPickupTime = Carbon::createFromFormat('h:i A', $request->pickuptime)->format('h:i A');

            Customer::create([
                'name' => $request->name,
                'kg' => $request->kg,
                'phoneno' => $request->phoneno,
                'pickuptime' => $formattedPickupTime,
                'date' => $formattedDate,
            ]);

            return redirect()->route('customer')->with('success', 'New customer successfully added');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to add new customer. Please try again.');
        }
    }

    public function editCustomer($id)
    {
        $data = Customer::find($id);
        return view('customerEdit', compact('data'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kg' => 'required|numeric',
            'phoneno' => 'required|string|max:255',
            'pickuptime' => 'required|string|max:255',
            'date' => 'required|date_format:d/m/Y',
        ]);

        $date = Carbon::createFromFormat('d/m/Y', $validated['date'])->format('Y-m-d');
        $formattedPickupTime = Carbon::createFromFormat('h:i A', $request->pickuptime)->format('h:i A');

        $customer = Customer::findOrFail($id);
        $customer->name = $validated['name'];
        $customer->kg = $validated['kg'];
        $customer->phoneno = $validated['phoneno'];
        $customer->pickuptime = $formattedPickupTime;
        $customer->date = $date;
        $customer->save();

        return redirect()->route('customer')->with('success', 'Customer data updated successfully.');
    }

    public function deleteCustomer($id)
    {
        $data = Customer::find($id);
        $data->delete();
        return redirect()->route('customer')->with('success', 'Customer successfully deleted');
    }
}
