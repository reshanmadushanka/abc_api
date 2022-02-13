<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel ,WithHeadingRow
{
    public $data;

    public function __construct()
    {
        $this->data = collect();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        //return an eloquent object
        $model = Customer::firstOrCreate([
            'email' => $row['email'],
        ], [
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
        ]);
        $this->data->push($model);
        return $model;
    }
}
