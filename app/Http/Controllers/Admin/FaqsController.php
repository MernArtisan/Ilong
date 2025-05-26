<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('id', 'desc')->get();
        return view('admin.faqs.index', compact('faqs'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function create()
    {
        return view('admin.faqs.manage'); // Empty form for creating a new FAQ
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        Faq::create($validated);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ added successfully.');
    }

    public function edit(string $id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faqs.manage', compact('faq')); // Load form with FAQ data for editing
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'is_active' => 'required|boolean',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($validated);

        return redirect()->route('admin.faq.index')->with('success', 'FAQ updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ deleted successfully.');
    }
}
