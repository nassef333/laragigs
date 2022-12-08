<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class Listings extends Controller{
    public function getAllListings(){
        // echo "<pre>";
        // var_dump(Auth()->id());
        // die();
        if (request('tag') ?? false) {
            $listings = Listing::latest()->where('tags', 'like', '%'.request('tag').'%')->get();
            return view('listings', compact('listings'));
        }
        else if(request('search' ?? false)){
            $listings = Listing::latest()->where('title', 'like', '%'.request('search').'%')->orWhere('description', 'like', '%'.request('search').'%')->orWhere('tags', 'like', '%'.request('search').'%')->get();

            return view('listings', compact('listings'));

        } 
        else {
            $listings = Listing::all();
            return view('listings', compact('listings'));
        }

        
    }

    public function getlisting($id){
        $listing = Listing::find($id);
        return view('listing', compact('listing'));
    }

    public function addlisting(){
        return view('addlisting');
    }
    public function storelisting(Request $request){
        // dd($request->file('logo')->store());
        $formFields = $request->validate([
            'title' => 'unique:listings|min:5|required',
            'tags' => 'required',
            'logo' => 'required',
            'company' =>'required|min:5',
            'location' =>'required|min:5',
            'email' =>'email|required|min:5',
            'website' =>'required|min:5',
            'description' =>'required|min:10'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Listing::insert($formFields);
        return redirect('listings');
    }

    public function delete($id){
        Listing::find($id)->delete();
        return redirect()->back();
    }

    public function editlisting($id){
        $data = Listing::find($id);
        // dd($data);
        return view('editlisting', compact('data', 'id'));
    }

    public function updatelisting(Request $request){
        $formFields = $request->validate([
            'title' => 'unique:listings|min:5|required',
            'tags' => 'required',
            'logo' => 'required',
            'company' =>'required|min:5',
            'location' =>'required|min:5',
            'email' =>'email|required|min:5',
            'website' =>'required|min:5',
            'description' =>'required|min:10'
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        Listing::where('id', $request->id)->update($formFields);
        return redirect('listings');
    }

    public function manage(){
        $listings = Listing::all();
        return view('manage', compact('listings'));
    }
}
