<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function submit(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $testimonial = new Testimonial();
        $testimonial->user_id = Auth::id();
        $testimonial->product_id = $id;
        $testimonial->comment = $request->comment;
        $testimonial->rating = $request->rating;
        $testimonial->save();

        return redirect()->back()->with('success', 'Testimonial submitted successfully!');
    }
}
