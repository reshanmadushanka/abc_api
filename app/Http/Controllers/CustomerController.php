<?php

namespace App\Http\Controllers;

use App\Http\Resources\CutomerResource;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customer_repo;

    public function __construct(CustomerRepository $customer_repo)
    {
        $this->customer_repo = $customer_repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get customers
        $customer = $this->customer_repo->get();
        if (isset($customer)) {
            return CutomerResource::collection($customer);
        }
        return $response = response()->json(['data' => 'Resource not found'], 404);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);

        try {
            $user = $this->customer_repo->save();
            //return successful response
            return response()->json(['res' => 'Customer created successfully.!', 'status' => 1]);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['res' => 'Customer Registration Failed!', 'status' => 0]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($customer = $this->customer_repo->get($id)) {
            return new CutomerResource($customer);
        }

        return $response = response()->json(['data' => 'Resource not found'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
        ]);

        try {
            $customer = $this->customer_repo->update($id);
            //return successful response
            return response()->json(['res' => 'Customer updated successfully.!', 'status' => 1]);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['res' => 'Customer Registration Failed!', 'status' => 0]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($customer = $this->customer_repo->delete($id)) {
            return response()->json(['res' => 'Customer updated successfully.!', 'status' => 1]);
        }
        return response()->json(['res' => 'Customer Registration Failed!', 'status' => 0]);
    }
}
