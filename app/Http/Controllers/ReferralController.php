<?php

namespace App\Http\Controllers;

use App\Referral;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        request()->user()->authorizeRoles(['admin', 'supervisor', 'executive']);
        $use_filter = false;
        $filters = $filterBase = $places = [];
        $referrals = new Referral();
        $d = $referrals->filterData();
        $places = $d["places"];
        $filterBase = $d["filterBase"];
        $placesJson = json_encode($places);
        $filtersJson = json_encode($filters);
        if($request->isMethod("get") && !strstr($request->fullUrl(), "filtered")){
            $referrals = Referral::paginate(15);
        }
        
        elseif($request->isMethod("get") && strstr($request->fullUrl(), "filtered")) {
            $use_filter = true;
            $where = [];
            foreach($request->get("filter") as $key=>$value)
            {
                if((preg_match("/\W/", str_replace(' ', '', $key))) || $value == null) continue; 
                $filters[$key] = $value;
                $where[] = [$key, "like", $value];
            }
           
            $filtersJson = json_encode($filters);
            
            $filteredReferrals = Referral::decryptedWhere(collect(Referral::all()), $filters);
            dd($filteredReferrals);
            $referrals = collect($filteredReferrals[0]);
            
            $perPage = 15; // Number of items per page
            $page = request('page', 1); // Current page number

            $referrals = new LengthAwarePaginator(
                $referrals->forPage($page, $perPage),
                $referrals->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }
        return view('referrals.index', compact('referrals', 'places', 'filterBase', 'placesJson', 'filters', 'filtersJson'))->with('filter', $use_filter);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        request()->user()->authorizeRoles(['admin', 'supervisor']);
        return view('referrals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        request()->user()->authorizeRoles(['admin', 'supervisor']);
        $this->validate(request(), [
            'reference_no' => 'required',
            'organisation' => 'required',
            'province' => 'required',
            'district' => 'required',
            'provider_name' => 'required',
            'phone' => 'required'
        ]);
        //
        $referral = Referral::create([
            "reference_no" => request("reference_no"),
            "organisation" => request("organisation"),
            "province" => request("province"),
            "district" => request("district"),
            "city" => request("city"),
            "street_addr" => request("street_addr"),
            "country" => request("country"),
            "email" => request("email"),
            "website" => request("website"),
            "zipcode" => request("zipcode"),
            "facility_type" => request("facility_type"),
            "gps_location" => request("gps_location"),
            "position" => request("position"),
            "provider_name" => request("provider_name"),
            "phone" => request("phone")
        ]);
        if (request("comment")) {
            Comment::create([
                "referral_id" => $referral->id,
                "user_id" => auth()->id,
                "comment" => request("comment"),
            ]);
        }

        return redirect('referrals');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function show(Referral $referral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function edit(Referral $referral)
    {
        //
        request()->user()->authorizeRoles(['admin', 'supervisor']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Referral $referral)
    {
        //
        request()->user()->authorizeRoles(['admin', 'supervisor']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Referral $referral)
    {
        //
        request()->user()->authorizeRoles(['admin', 'supervisor']);
    }

    public function upload()
    {
        request()->user()->authorizeRoles(['admin', 'supervisor']);
        return view('referrals.upload');
    }

    public function processUpload(Request $request)
    {
        request()->user()->authorizeRoles(['admin', 'supervisor']);
        $cols = array(
            'country',
            'reference_no',
            'organisation',
            'province',
            'district',
            'city',
            'street_address',
            'gps_location',
            'facility_name',
            'facility_type',
            'provider_name',
            'position',
            'phone',
            'email',
            'website',
            'pills_available',
            'code_to_use',
            'type_of_service',
            'note',
            'womens_evaluation'
        );
        if ($request->file('referral_file')->isValid()) {
            
            if ($request->referral_file->extension() == "txt") {
                $file = fopen($request->referral_file->path(), "r");
                $all_data = array();
                $ctr = 0;
                $failed = array();
                while (($data = fgetcsv($file, 200, ",")) !== FALSE) {
                   
                    if (count($cols) == count($data)) {
                        

                        $arr = array_combine($cols, $data);
                        Referral::create($arr);
                        $ctr++;
                    } else {
                        //ignore empty data-block by checking if first data element is null, log error otherwise.
                        if ($data[0] != null) {
                            $failed[] = $data[1];
                            Log::critical("Failed - data c = " . count($data) .  " field c = " . count($cols) . " => " . implode(',', $data));
                        }
                    }
                    // print_r($arr);

                    // break;
                    // echo "<hr />";
                    // $ctr++;
                    $request->session()->flash('status', $ctr . ' records uploaded successful!');
                    if (count($failed) > 0) {
                        $request->session()->flash('error', "Reference Nos. " . implode(',', $failed) . ' failed to upload!');
                    }
                }
            }
        }
        return redirect('referrals');
    }
}
