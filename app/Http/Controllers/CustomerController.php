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
        };


        return view('customerList', compact('data'));
    }

    public function customerAdd()
    {
        return view('customerAdd');
    }

    public function insertNewCustomer(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kg' => 'required|integer',
            'phoneno' => 'required|string|max:15',
            'pickuptime' => 'required|string',
            'date' => 'required|date_format:d/m/Y',
        ]);

        try {
            // Convert the date format
            $formattedDate = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');

            // Create a new customer with the formatted date
            Customer::create([
                'name' => $request->name,
                'kg' => $request->kg,
                'phoneno' => $request->phoneno,
                'pickuptime' => $request->pickuptime,
                'date' => $formattedDate,
            ]);

            return redirect()->route('customer')->with('success', 'New customer successfully added');
        } catch (\Exception $e) {
            // Handle exception: Display error message and redirect back to form
            return redirect()->back()->withInput()->with('error', 'Failed to add new customer. Please try again.');
        }
    }


    public function editCustomer($id)
    {
        $data = Customer::find($id);
        //dd($data);
        return view('customerEdit', compact('data'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kg' => 'required|numeric',
            'phoneno' => 'required|string|max:255',
            'pickuptime' => 'required|string|max:255',
            'date' => 'required|date_format:d/m/Y', // Ensure date is in dd/mm/yyyy format
        ]);
        // Convert date format from dd/mm/yyyy to yyyy-mm-dd for MySQL
        $date = \Carbon\Carbon::createFromFormat('d/m/Y', $validated['date'])->format('Y-m-d');

        // Update the customer record in the database
        $customer = Customer::findOrFail($id);
        $customer->name = $validated['name'];
        $customer->kg = $validated['kg'];
        $customer->phoneno = $validated['phoneno'];
        $customer->pickuptime = $validated['pickuptime'];
        $customer->date = $date; // Use the converted date format
        $customer->save();

        // Redirect back with success message or handle as needed
        return redirect()->route('customer')->with('success', 'Customer data updated successfully.');
    }

    public function deleteCustomer($id)
    {
        $data = customer::find($id);
        $data->delete();
        return redirect()->route('customer')->with('success', 'Customer successfully deleted');
    }
}
