<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function getAll(){
        // $company  = Company::all();
        $company= Company::orderBy('name')->get();

        $respond = [
            'status'=> 201,
            'message' => "All Company",
            'data' => $company,
        ];

        return $respond;
    }

    public function get($id){
        $company= Company::find($id);

        if(!isset($company)){

            $respond = [
                'status'=> 404,
                'message' => "Company of id=$id doesn't exist",
                'data' => $company,
            ];

            return $respond;
        }

        $respond = [
            'status'=> 201,
            'message' => "Company of id $id",
            'data' => $company,
        ];

        return $respond;
    }


    public function create(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'string|email|max:255',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048|dimensions:min_width=100,min_height=100',
            'website' => 'string',
        ]);

        if ($validator->fails()) {
            $respond = [
                'status'=> 404,
                'message' =>  $validator->errors()->first(),
                'data' => null,
            ];

            return $respond;
        }

        if ($files = $request->file('logo')) {
            $destinationPath = 'image/'; // upload path
            $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $profileImage);
        }

        $company = new Company;
        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $profileImage;
        $company->website = $request->website;
        $company->save();

        return $company;

    }

    public function update(Request $request, $id){

        $company = Company::find($id);


        if(isset($company)){

            $validator = Validator::make($request->all(), [
                'name' => 'string|between:2,100',
                'email' => 'string|email|max:255',
                'logo' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048|dimensions:min_width=100,min_height=100',
                'website' => 'string',
            ]);

            if ($validator->fails()) {
                $respond = [
                    'status'=> 404,
                    'message' =>  $validator->errors()->first(),
                    'data' => null,
                ];

                return $respond;
            }

            if ($files = $request->file('logo')) {
                $destinationPath = 'image/'; // upload path
                $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage);
            }

            $request->name? $company->name = $request->name: null;
            $request->email? $company->email = $request->email: null;
            $profileImage? $company->logo = $profileImage: null;
            $request->website? $company->website = $request->website: null;
            $company->save();

            $respond = [
                'status'=> 201,
                'message' =>  "Company updated successfully",
                'data' => $company,
            ];

            return $respond;
        }

        $respond = [
            'status'=> 404,
            'message' =>  "Company with id=$id doesn't exist",
            'data' => null,
        ];

        return $respond;
    }

    public function delete($id){

        $company = Company::find($id);

        if(isset($company)){
            $company->delete();
            $all_companies = Company::all();
            foreach($all_companies as $each){
                $each->section;
            }

            $respond = [
                'status'=> 201,
                'message' =>  "Successfully Deleted",
                'data' => $all_companies,
            ];
            return $respond;
        }

            $respond = [
                'status'=> 404,
                'message' =>  "Company with id=$id doesn't exist",
                'data' => null,
            ];

        return $respond;

    }
}
