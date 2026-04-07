<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Exceptions\CouldNotLoadImage;
use Spatie\Image\Image;
use Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $tags = Tag::all();

        $posts = Post::with(['user', 'tags'])
            ->latest()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%");
                });
            })
            ->when($request->tag, function($query, $tag) {
                $query->whereHas('tags', fn($q) => $q->where('tags.id', $tag));
            })
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', compact('posts', 'tags'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('posts.create', compact('tags'));
    }

    /**
     * @throws CouldNotLoadImage
     */
    public function store(Request $request)
    {
        // validation
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'cover_image' => 'image|max:2048',
        ]);

        // cover image
        $coverImageFile = null;
        if ($request->hasFile('cover_image'))
            $coverImageFile = $request->file('cover_image');

        $path = $coverImageFile->store('temp');
        $finalPath = $coverImageFile->hashName();

        Image::load(storage_path('app/private/' . $path))
            ->fit(Fit::Contain, 1024, 1024)
            ->optimize()
            ->save(storage_path('app/public/' . $finalPath));

        Storage::delete($path);

        // creation
        $post = $request->user()->posts()->create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'cover_image' => $finalPath,
        ]);

        // tags
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

    /**
     * @throws CouldNotLoadImage
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
            'cover_image' => 'image|max:2048'
        ]);

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }

            $coverImageFile = $request->file('cover_image');
            $path = $coverImageFile->store('temp');
            $finalPath = $coverImageFile->hashName();

            Image::load(storage_path('app/private/' . $path))
                ->fit(Fit::Contain, 1024, 1024)
                ->optimize()
                ->save(storage_path('app/public/' . $finalPath));

            Storage::delete($path);
            $post->cover_image = $finalPath;
        }

        $post->tags()->sync($validated['tags'] ?? []);
        $post->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'cover_image' => $post->cover_image
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
