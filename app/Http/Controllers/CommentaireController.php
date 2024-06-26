<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;

class CommentaireController extends Controller
{
    public function store(Request $request)
    {
        // Valider les données de la requête
        $request->validate([
            'contenu' => 'required|string|max:255',
            'post_id' => 'required|exists:posts,id',
        ]);

        // Créer le commentaire
        $commentaire = Commentaire::create([
            'contenu' => $request->contenu,
            'user_id' => auth()->id(),
            'post_id' => $request->post_id,
        ]);

        // Charger la relation user
        $commentaire->load('user');

        // Retourner une réponse JSON
        return response()->json(['success' => 'Commentaire ajouté avec succès!', 'commentaire' => $commentaire]);
    }

    public function index($postId)
    {
        // Récupérer les commentaires pour le post donné
        $commentaires = Commentaire::where('post_id', $postId)->with('user')->get();
        return response()->json($commentaires);
    }
}
