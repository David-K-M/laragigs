<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Validation\Rule;

class ListingController extends Controller 
{
    //show all listings
    public function index(){
        
        return view('listings.index', [
            'listings' => Listing::latest()->filter
            (request(['tag','search']))->simplePaginate(5)
         ]);
    }

    //Show create form
    public function create() {
        return view ('listings.create');
    }
    
    //Show single listings
    public function show(Listing $listing) {
        return view ('listings.show', [
            'listing' => $listing
        ]);
    }

    //Store
    public function store(Request $request){
        
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

         return redirect('/')->with('message', 'Listing created successfully!');   
    }
    
    //Show edit
    public function edit(Listing $listing){
    
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request, Listing $listing){
        
        //Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required', 
            'location' => 'required',
            'website' => 'required',
            'email' => ['required','email'],
            'tags' => 'required',
            'description' => 'required',
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        $listing->update($formFields);

         return back()->with('message', 'Listing updated successfully!');   
    }

    //Delete Listing
    public function destroy(Listing $listing){

        //Make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action');
        }
        
        $listing->delete();
        return redirect ('/')->with('message','Listing deleted successfully!');
    }

    //Manage Listing
    public function manage(){
        return view('listings.manage', ['listings'=> auth()->user()->listings()->get() ]);

    }
}
