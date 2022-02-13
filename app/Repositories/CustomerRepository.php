<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Models\CustomerPhone;

class CustomerRepository
{

    /**
     * @return void
     * get customer from the db
     */
    public function get($id = '')
    {
        $customer = Customer::with('phone')
            ->when($id, function ($q) use ($id) {
                $q->where('id', $id);
            })->when(request('key'), function ($q) {
                $q->where('first_name', "LIKE", "%" . request('id') . "%")
                    ->orWhere('last_name', request('key'))
                    ->orWhere('email', request('key'));
            })
            ->get();

        return $customer;
    }

    public function save()
    {

        $customer = new Customer;
        $customer->first_name = request('first_name');
        $customer->last_name = request('last_name');
        $customer->email = request('email');

        if ($customer->save()) {
            if (request()->filled('phone')) {
                foreach (request('phone') as $phone) {
                    $data[] = [
                        'customerId' => $customer->id,
                        'phone' => $phone,
                    ];
                }
                $phone = CustomerPhone::insert($data);
            }
            return $customer->id;
        }

        return false;


    }

    public function update($id)
    {
        $customer = Customer::find($id);
        $customer->first_name = request('first_name');
        $customer->last_name = request('last_name');
        $customer->email = request('email');
        if ($customer->update()) {
            if (request()->filled('phone')) {
                foreach (request('phone') as $phone) {
                    CustomerPhone::firstOrCreate(
                        ['customerId' => $id],
                        ['phone' => $phone]
                    );
                }
            }
            return $customer;
        }
        return false;
    }

    public function delete($id = "")
    {
        $customer = Customer::find($id);
        if ($customer->delete()) {
            CustomerPhone::where('customerId', $id)->delete();
            return $customer;
        }
        return false;
    }

}
