<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminTagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('posts')->orderBy('name')->get();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:tags,name',
        ]);

        Tag::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.tags.index')->with('status', 'Tag Created Successfully!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('status', 'Tag Deleted Successfully!');
    }
}
