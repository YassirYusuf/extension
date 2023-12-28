<?php

namespace App\Http\Controllers;

use App\Models\Subpage;
use Illuminate\Http\Request;
use App\Http\Requests\CreateSubpageRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubpageController extends Controller
{
 
     // Display the specified subpage
    public function showSubpage($slug)
    {
        $subpage = Subpage::with(['posts' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->where('slug', $slug)->firstOrFail();
        return view('subpages.show', compact('subpage'));
    }

    // Method to show all subpages
   

    // Method to handle the search
    public function search(Request $request)
    {
        $query = Subpage::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $subpages = $query->get();
        return view('subpages.subpages', compact('subpages'));
    }
    public function subscribed()
    {
        return view('subpages.subscribed');
    }


    // Show the form for creating a new subpage
    public function create()
    {
        return view('subpages.create');
    }

    // Store a newly created subpage
    public function store(CreateSubpageRequest $request) // Using custom request for validation
    {
        $subpage = new Subpage();
        $subpage->name = $request->name; // Ensure this matches your form's input name for the subpage name
        $subpage->description = $request->description; // This can be null, so it's okay if it's not set
        $subpage->owner_id = auth()->id(); // Setting the authenticated user as the owner of the subpage
        $subpage->slug = Str::slug($request->name);
        $subpage->save();

        // Subscribe the user
        auth()->user()->subscriptions()->attach($subpage->id);
        
        return redirect()->route('subpages.showSubpage', $subpage->slug);
    }

    /*public function destroy($slug, $postSlug)
    {
         // First, get the correct subpage using its slug
        // - this is necessary because the post_slug only is unique for the subpage
        $subpage = Subpage::where('slug', $slug)->firstOrFail();

        // Then, get the post by its slug and make sure it belongs to the correct subpage
        //$post = Post::where('slug', $postSlug)->where('subpage_id', $subpage->id)->firstOrFail();
    
        if ($post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $post->delete();
    
        return back()->with('status', 'Post deleted successfully.');
    }
    */

   
}
