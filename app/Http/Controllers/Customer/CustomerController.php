<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\SaleItem;
use App\Models\Sale;
use App\Models\Employee;
use App\Models\CustomerAssignment;

class CustomerController extends Controller
{
    public function purchaseHistory(){
        $customers = Customer::all();
        return view('customer.purchase', compact('customers'));
    }

    public function customerPurchaseList($customerId){
        $customer = Customer::findOrFail($customerId);
        $customerOrders = Sale::where('customer_id', $customer->id)
            ->latest('sale_date')
            ->get();

        return view('customer.purchase-list', compact(
            'customer',
            'customerOrders'
        ));
    }

    public function showSale($reg) {
        $saleItems = SaleItem::with('product')->where('reg', $reg)->get();

        return view('customer.items-list', compact(
            'saleItems',
        ));
    }

    public function customerList()
    {
        $employees = Employee::with('assignments')->get();

        return view('customer.employee-list', compact('employees'));
    }

    public function assignCustomer($employeeId){
        $employee = Employee::with('assignments')->findOrFail($employeeId);

        $customers = Customer::where(function ($query) {
            $query->where('last_purchase_at')->orWhere('last_purchase_at', '<', Carbon::now()->subDays(90));
        })->get();

        return view('customer.inactive-customer', compact('customers', 'employee'));
    }

    public function assignCustomerToEmployee($customerId, $employee_id){
        $customer = Customer::findOrFail($customerId);

        $employee = Employee::with('assignments')->findOrFail($employee_id);

        $assignment = CustomerAssignment::where('customer_id', $customerId)->first();

        if ($assignment) {
            return back()->with('warning', 'This customer has already been assigned.');
        }

        $assigned = CustomerAssignment::where('customer_id', $customer->id)
            ->where('employee_id', $employee->id)
            ->exists();

        if ($assigned) {
            return back()->with('warning', 'Customer has already been assigned to this employee.');
        }

        CustomerAssignment::create([
            'customer_id'   => $customer->id,
            'employee_id'   => $employee->id,
            'assigned_at'   => now(),
            'remarks'       => 'Customer assign to employee by admin.',
        ]);

        return redirect()->back()->with('success', 'Customer assign to employee');
    }

    public function customerAssignList(){
        $assignEmployeeAndCustomer = CustomerAssignment::with(['customer','employee'])->get();

        return view('customer.assign-list', compact('assignEmployeeAndCustomer'));
    }

    public function assignDestroy($id){
        $assignment = CustomerAssignment::findOrFail($id);

        $assignment->delete();

        return back()->with('success', 'Customer assignment removed successfully.');
    }
}
