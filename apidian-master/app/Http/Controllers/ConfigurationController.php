<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeDocumentIdentification;
use App\TypeDocument;
use App\TypeOrganization;
use App\TypeRegime;
use App\Country;
use App\Department;
use App\Municipality;
use App\User;
use App\Http\Resources\CompaniesCollection;



class ConfigurationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {   
       // $list =  new CompaniesCollection(User::all());
        //return json_encode($list);
        return view('configurations.index') ; 
    }

    public function configuration_admin()
    {
        return view('configurations.formadmin');
    }

    public function records(Request $request)
    {
        $records = User::all();
        return new CompaniesCollection($records);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tables()
    {
        $type_document_identification = TypeDocumentIdentification::all();
        $type_organization = TypeOrganization::all();
        $type_regime = TypeRegime::all();
        $department = Department::where('country_id', 46)->get();
        $ids_department = $department->pluck('id');
        $municipality = Municipality::whereIn('department_id', $ids_department)->get();
        $type_document = TypeDocument::all();


        return compact( 'type_document_identification','type_organization', 'type_regime', 'department', 'municipality', 'type_document');
    }




 

    


}
