<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('kg', 'LIKE', '%' . $search . '%')
                ->orWhere('phoneno', 'LIKE', '%' . $search . '%');
        }

        $data = $query->paginate(10);

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

    public function markCompleted($id)
    {
        // Fetch the customer data by id
        $customer = Customer::find($id);

        // Store the completed order in session
        $completedOrders = Session::get('completedOrders', []);
        $completedOrders[] = $customer;
        Session::put('completedOrders', $completedOrders);

        // Remove the customer from the main list
        $customer->delete();

        // Check if the current page is empty
        $page = request()->input('page', 1); // Get current page or default to 1
        $perPage = 10; // Number of items per page
        $totalItems = Customer::count();
        $totalPages = ceil($totalItems / $perPage);

        // Redirect to previous page if current page becomes empty
        if ($page > 1 && $page > $totalPages) {
            return redirect()->route('customer', ['page' => $totalPages])->with('success', 'Order marked as completed and moved to Completed Orders.');
        }

        return redirect()->route('customer')->with('success', 'Order marked as completed and moved to Completed Orders.');
    }


    public function completedOrders(Request $request)
    {
        $completedOrders = Session::get('completedOrders', []);

        // Implement search functionality for completed orders
        if ($request->has('completedSearch')) {
            $search = $request->completedSearch;
            $filteredOrders = collect($completedOrders)->filter(function ($order) use ($search) {
                return stripos($order->name, $search) !== false
                    || stripos($order->kg, $search) !== false
                    || stripos($order->phoneno, $search) !== false;
            });
            $completedOrders = $filteredOrders->values()->all();
        }

        return view('completedOrders', compact('completedOrders'));
    }

    public function undoDelete($id)
    {
        // Retrieve the customer from session
        $completedOrders = Session::get('completedOrders', []);

        // Find the customer to undo delete
        $customerToRestore = collect($completedOrders)->firstWhere('id', $id);

        if ($customerToRestore) {
            // Convert the date format from d/m/Y to Y-m-d
            $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $customerToRestore->date)->format('Y-m-d');

            // Restore the customer to the main list with the original ID
            Customer::insert([
                'id' => $customerToRestore->id,
                'name' => $customerToRestore->name,
                'kg' => $customerToRestore->kg,
                'phoneno' => $customerToRestore->phoneno,
                'pickuptime' => $customerToRestore->pickuptime,
                'date' => $formattedDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Remove the customer from completed orders session
            $filteredOrders = collect($completedOrders)->reject(function ($order) use ($id) {
                return $order->id == $id;
            });
            Session::put('completedOrders', $filteredOrders->values()->all());

            return redirect()->route('completedOrders')->with('success', 'Customer data restored successfully.');
        }

        return redirect()->route('completedOrders')->with('error', 'Failed to restore customer data.');
    }
}
