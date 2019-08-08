<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.customer');
    }

    public function getcustomer()
    {
        return Customer::all();
    }

    public function savecustomer(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'required',
        ]);

        if ($request->editflag != false) {
            $save = Customer::where('id', $request->customerid)->first();
        } else {
            $save = new Customer();
        }

        $save->company_name = $request->company_name;
        $save->company_name_en = $request->company_name_en;
        $save->description = $request->description;
        $save->address = $request->address;
        $save->save();
    }

    public function deletecustomer(Request $request)
    {
        Customer::where('id', $request->id)->delete();
    }
}
