<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $post = $request->user()->posts()->create([
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        $post->tags()->attach($validated['tags'] ?? []);

        return redirect()->route('posts.index')->with('status', 'Post Created Successfully!');
    }

    public function show(Post $post)
    {
        $post->load(['user', 'tags']);
        return view('post.view', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $tags = Tag::all();
        return view('posts.edit', compact('post', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        $post->tags()->sync($validated['tags'] ?? []);
        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('posts.show', $post)
            ->with('status', 'Post Edited Successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Post Deleted!');
    }
}
