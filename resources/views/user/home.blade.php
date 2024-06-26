@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h4>{{ __('Bienvenu chez toi') }}</h4>
                    <div class="row">
                        @foreach ($posts as $post)
                        <div class="col-md-4 mb-3 position-relative">
                            @php
                                $isBlurred = Auth::user()->status == 0 && $post->type != 0;
                            @endphp
                            <a href="#" class="post-link" data-image="{{ $post->photo_video }}" data-type="{{ $post->type }}" data-post-id="{{ $post->id }}"
                               @if ($isBlurred) onclick="return false;" @endif>
                                <img src="{{ $post->photo_video }}" alt="Post Image" class="img-thumbnail {{ $isBlurred ? 'blurred' : '' }}">
                                @if ($isBlurred)
                                <div class="eye-icon-overlay">
                                    <i class="fas fa-eye-slash"></i>
                                </div>
                                @endif
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for displaying full-size image and comments -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content flex h-full">
            <div class="modal-body relative overflow-hidden" style="height: calc(100vh - 200px); display: flex; flex-direction: column; justify-content: center; align-items: center;">
                
                <img src="" alt="Full-size Image" class="img-fluid max-w-full max-h-full object-contain mb-4" id="fullImage">
                
                <div class="absolute inset-0 flex justify-between items-center z-10">
                    <button type="button" class="btn btn-secondary px-4 py-2 rounded text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:bg-indigo-500 w-5/12 h-full opacity-0" id="prevBtn">&lt; Previous</button>
                    <button type="button" class="btn btn-primary px-4 py-2 rounded text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:bg-blue-500 w-5/12 h-full opacity-0" id="nextBtn">Next &gt;</button>
                </div>

            </div>
            <div class="modal-body relative overflow-hidden">
                <!-- Formulaire de commentaire -->
                <form id="commentForm" class="w-full mb-3">
                    @csrf
                    <input type="hidden" name="post_id" id="post_id">
                    <textarea name="contenu" id="contenu" rows="3" class="form-control mb-3" placeholder="Écrire un commentaire..."></textarea>
                    <button type="submit" class="btn btn-primary">Commenter</button>
                </form>

                <!-- List of comments -->
                <div id="commentsList" class="w-full"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Ouvrir le modal et afficher la photo en grand lors du clic sur un lien de poste
    $('.post-link').on('click', function(e) {
        if ($(this).attr('onclick')) {
            return;
        }
        e.preventDefault();
        var imageSrc = $(this).data('image');
        var postId = $(this).data('post-id');
        $('#fullImage').attr('src', imageSrc);
        $('#post_id').val(postId);
        $('#imageModal').modal('show');
        loadComments(postId); // Charger les commentaires
    });

    // Soumission du formulaire de commentaire via AJAX
    $('#commentForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('commentaires.store') }}",
            type: "POST",
            data: formData,
            success: function(response) {
                alert('Commentaire ajouté avec succès!');
                $('#contenu').val(''); // Réinitialiser le champ de commentaire
                addComment(response.commentaire); // Ajouter le commentaire à la liste
            },
            error: function(response) {
                alert('Une erreur s\'est produite lors de l\'ajout du commentaire.');
            }
        });
    });

    // Ajouter un commentaire à la liste
    function addComment(comment) {
        var commentHtml = `
            <div class="comment mb-2 p-2 bg-gray-100 rounded position-relative" data-comment-id="${comment.id}">
                <strong>${comment.user.name}</strong>
                <p class="comment-content">${comment.contenu}</p>
            </div>
        `;
        $('#commentsList').append(commentHtml);
    }

    // Charger les commentaires pour un post
    function loadComments(postId) {
        $.ajax({
            url: `/commentaires/${postId}`,
            type: 'GET',
            success: function(response) {
                $('#commentsList').empty();
                response.forEach(function(comment) {
                    addComment(comment);
                });
            },
            error: function(response) {
                alert('Une erreur s\'est produite lors du chargement des commentaires.');
            }
        });
    }

    // Désactiver le menu contextuel et les raccourcis de capture d'écran
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'PrintScreen' || (e.ctrlKey && e.key === 'p') || (e.ctrlKey && e.key === 's')) {
            e.preventDefault();
            alert('Captures d\'écran et l\'impression sont désactivées sur ce site.');
        }
    });
});

</script>

<style>
    .blurred {
        filter: blur(8px);
        pointer-events: none;
    }

    .eye-icon-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: red;
        font-size: 2rem;
        pointer-events: none;
    }
</style>
@endsection
