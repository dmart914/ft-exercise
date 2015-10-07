<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use DB;

class ListingsController extends Controller
{
    public function __construct() {
        $this->beforeFilter('csrf', array('on' => ['post', 'put']));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listings = \App\Listing::all();
        return view('index')->withListings($listings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('listings_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'mls_number'    => 'required|unique:listings,mls_number|numeric',
            'street_1'      => 'required|unique:listings,street_1',
            'city'          => 'required',
            'state'         => 'required|alpha',
            'zip'           => 'numeric',
            'sale_price'    => 'numeric|required',
            'date_listed'   => 'date|required',
            'bedrooms'      => 'numeric|required',
            'photos'        => 'image',
            'square_feet'   => 'numeric|required',
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            return redirect()->route('listings.create')->withErrors($validator)->withInput();
        }

        $listing = new \App\Listing;
        $listing->mls_number = $request->input('mls_number');
        $listing->street_1 = $request->input('street_1');
        $listing->street_2 = $request->input('street_2');
        $listing->city = $request->input('city');
        $listing->state = $request->input('state');
        $listing->zip = $request->input('zip');
        $listing->neighborhood = $request->input('neighborhood');
        $listing->sale_price = $request->input('sale_price');
        $listing->date_listed = $request->input('date_listed');
        $listing->bedrooms = $request->input('bedrooms');

        if ($request->hasFile('photos') && $request->file('photos')->isValid()) {
            $photo_name = $request->mls_number . "."
            . $request->file('photos')->getClientOriginalExtension();
            
            $request->file('photos')
                   ->move('/home/pi/five-talents/real-estate/public/photos',
                       $photo_name);

            $listing->photos = (string)$listing->photos . $photo_name . ";";
        }

        $listing->square_feet = $request->input('square_feet');
        $listing->description = $request->input('description');

        $listing->save();

        return redirect()->route('listings.index')->withMessage('Listing created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $listing = \App\Listing::findOrFail($id);

        $photos = $listing->photos;
        $photos = explode(';', $photos);

        return view('listing_show')
            ->withListing($listing)
            ->withPhotos($photos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $listing = \App\Listing::findOrFail($id);

        $photos = $listing->photos;
        $photo_count = substr_count($photos, ';');
        $photos = explode(';', $photos);

        return view('listing_edit')->withListing($listing)
            ->withPhotos($photos)
            ->withPhotocount($photo_count);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'mls_number'    => 'required|numeric',
            'street_1'      => 'required',
            'city'          => 'required',
            'state'         => 'required|alpha',
            'zip'           => 'numeric',
            'sale_price'    => 'numeric|required',
            'date_listed'   => 'date|required',
            'bedrooms'      => 'numeric|required',
            'photos'        => 'image',
            'square_feet'   => 'numeric|required',
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->errors();
            return redirect()->route('listings.create')->withErrors($validator)->withInput();
        }

        $listing = \App\Listing::findOrFail($id);
        $listing->mls_number = $request->input('mls_number');
        $listing->street_1 = $request->input('street_1');
        $listing->street_2 = $request->input('street_2');
        $listing->city = $request->input('city');
        $listing->state = $request->input('state');
        $listing->zip = $request->input('zip');
        $listing->neighborhood = $request->input('neighborhood');
        $listing->sale_price = $request->input('sale_price');
        $listing->date_listed = $request->input('date_listed');
        $listing->bedrooms = $request->input('bedrooms');

        if ($request->hasFile('photos') && $request->file('photos')->isValid()) {
            $photo_name = $request->mls_number . "."
            . $request->file('photos')->getClientOriginalExtension();
            
            $request->file('photos')
                   ->move('/home/pi/five-talents/real-estate/public/photos',
                       $photo_name);

            $listing->photos = (string)$listing->photos . $photo_name . ";";
        }

        $listing->square_feet = $request->input('square_feet');
        $listing->description = $request->input('description');

        $listing->update();

        return redirect()->route('listings.index')->withMessage('Listing updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $listing = \App\Listing::findOrFail($id)->delete();
        return redirect()->route('listings.index')->withMessage('Listing deleted.');
    }

    public function search() {
        return view('listings_search');

    }

    public function search_results(Request $request) {
        $q = "select * from listings WHERE ";

        // query field
        if (strlen($request->input('query')) > 0) {
            $fields = array();
            
            if ($request->has("mls")) {
                array_push($fields, "mls_number");
            }

            if ($request->has("city_state")) {
                array_push($fields, "street_1");
                array_push($fields, "street_2");
                array_push($fields, "city");
                array_push($fields, "state");
            }

            if ($request->has("zip")) {
                array_push($fields, "zip");
            }

            $fields_combined = "";
            for ($i = 0; $i < sizeof($fields); $i++) {
                if ($i == 0) {
                    $fields_combined = $fields_combined . "(";
                }

                $fields_combined = $fields_combined . "(" . $fields[$i] . " LIKE '%" . $request->get("query") . "%')";
                
                if ($i < (sizeof($fields) - 1)) {
                    $fields_combined = $fields_combined . " OR ";
                } else {
                    $fields_combined = $fields_combined . ")";
                }
            }

            $q = $q . $fields_combined;

            if (($request->has("date") || $request->has("bedrooms") || $request->has("square_feet")) && ($request->has("mls") || $request->has("city_state") || $request->has("zip"))) {
                $q = $q . " AND ";
            }
        }

        // date
        if ($request->has("date")) {
            $sub_q = "(date_listed ";
            if (strlen($request->get("date_start") > 0)) {
                $sub_q = $sub_q . ">= '" . $request->get("date_start") . "' ";
            }
            if (strlen($request->get("date_end")) > 0) {
                if (strlen($request->get("date_start") > 0)) {
                    $sub_q = $sub_q . " AND ";
                }
                $sub_q = $sub_q . "date_listed <= '" . $request->get("date_end") . "'";
            } 
            $sub_q = $sub_q . ")";

            $q = $q . $sub_q;
            
            if ($request->has("bedrooms") || $request->has("square_feet")) {
                $q = $q . " AND ";
            }
        }

        if ($request->has("bedrooms")) {
            $sub_q = "(bedrooms ";
            if (strlen($request->get("bedrooms_min"))) {
                $sub_q = $sub_q . ">= " . $request->get("bedrooms_min");
            }
            if (strlen($request->get("bedrooms_max")) > 0) {
                if (strlen($request->get("bedrooms_min")) > 0) {
                    $sub_q = $sub_q . " AND ";
                }
                $sub_q = $sub_q . "bedrooms <= " . $request->get("bedrooms_max");
            }
            $sub_q = $sub_q . ")";

            $q = $q . $sub_q;

            if ($request->has("square_feet")) {
                $q = $q . " AND ";
            }

        }

        if ($request->has("square_feet")) {
            $sub_q = "(square_feet ";
            if (strlen($request->get("square_feet_min"))) {
                $sub_q = $sub_q . ">= " . $request->get("square_feet_min");
            }
            if (strlen($request->get("square_feet_max")) > 0) {
                if (strlen($request->get("square_feet_min")) > 0) {
                    $sub_q = $sub_q . " AND ";
                }
                $sub_q = $sub_q . "square_feet <= " . $request->get("square_feet_max");
            }
            $sub_q = $sub_q . ")";
            
            $q = $q . $sub_q;
        }

        $results = DB::select($q);
        return view('listings_search')->withResults($results);

    }
}
