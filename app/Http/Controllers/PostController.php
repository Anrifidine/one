<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('auth.home', compact('posts'));
    }
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'photo_video' => 'required|file|mimes:jpg,jpeg,png,mp4|max:20480',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        // Gérer le téléchargement du fichier
        if ($request->hasFile('photo_video')) {
            $filePath = $request->file('photo_video')->store('public/uploads');
            $fileUrl = Storage::url($filePath);
        } else {
            $fileUrl = null;
        }

        // Créer un nouveau post avec les données validées
        $post = new Post;
        $post->title = $request->title;
        $post->type = $request->type;
        $post->photo_video = $fileUrl;
        $post->user_id = $request->user_id;
        $post->save();

        // Rediriger l'utilisateur avec un message de succès
        return redirect()->route('posts.index')->with('status', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // Valider les données du formulaire
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'photo_video' => 'file|mimes:jpg,jpeg,png,mp4|max:20480',
        ]);

        // Gérer le téléchargement du fichier
        if ($request->hasFile('photo_video')) {
            // Supprimer l'ancien fichier s'il existe
            if ($post->photo_video) {
                Storage::delete(str_replace('/storage/', 'public/', $post->photo_video));
            }

            $filePath = $request->file('photo_video')->store('public/uploads');
            $fileUrl = Storage::url($filePath);
            $post->photo_video = $fileUrl;
        }

        // Mettre à jour les autres champs
        $post->title = $request->title;
        $post->type = $request->type;
        $post->save();

        // Rediriger l'utilisateur avec un message de succès
        return redirect()->route('auth.home')->with('status', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Supprimer le fichier associé au post
        if ($post->photo_video) {
            Storage::delete(str_replace('/storage/', 'public/', $post->photo_video));
        }

        // Supprimer le post
        $post->delete();

        return redirect()->route('auth.home')->with('status', 'Post deleted successfully!');
    }
}
