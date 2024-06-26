@extends('layouts.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('Dashboard') }}
                    <div>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary">Créer un nouveau poste</a>
                        <a href="{{ route('auth.users') }}" class="btn btn-secondary">Gérer utilisateur</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h4>{{ __('Bienvenu chez toi ') }}</h4>
                    <div class="row">
                        @foreach ($posts as $post)
                        <div class="col-md-4 mb-3">
                            <a href="#" class="post-link" data-image="{{ $post->photo_video }}">
                                <img src="{{ $post->photo_video }}" alt="Post Image" class="img-thumbnail">
                            </a>
                            <!-- Boutons Modifier et Supprimer -->
                            <div class="mt-2 flex justify-between">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce poste ?')">Supprimer</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for displaying full-size image -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content flex h-full">
            <div class="modal-body relative overflow-hidden" style="height: calc(100vh - 200px); display: flex; justify-content: center; align-items: center;">
                <img src="" alt="Full-size Image" class="img-fluid max-w-full max-h-full object-contain" id="fullImage">
                
                <div class="absolute inset-0 flex justify-between items-center z-10">
                    <button type="button" class="btn btn-secondary px-4 py-2 rounded text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:bg-indigo-500 w-5/12 h-full opacity-0" id="prevBtn">&lt; Previous</button>
                    <button type="button" class="btn btn-primary px-4 py-2 rounded text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 hover:bg-blue-500 w-5/12 h-full opacity-0" id="nextBtn">Next &gt;</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inclure le JavaScript directement dans la vue -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    // Ouvrir le modal et afficher la photo en grand lors du clic sur un lien de poste
    $('.post-link').on('click', function(e) {
        e.preventDefault();
        var imageSrc = $(this).data('image');
        $('#fullImage').attr('src', imageSrc);
        $('#imageModal').modal('show');
    });

    // Navigation vers la photo suivante
    $('#nextBtn').on('click', function() {
        var currentImage = $('#fullImage').attr('src');
        var currentIndex = -1;
        // Trouver l'index de l'image actuelle dans la liste des posts
        $('.post-link').each(function(index) {
            if ($(this).data('image') === currentImage) {
                currentIndex = index;
                return false; // Arrêter la boucle
            }
        });
        // Passer à l'image suivante si elle existe
        if (currentIndex !== -1 && currentIndex < $('.post-link').length - 1) {
            var nextImageSrc = $('.post-link').eq(currentIndex + 1).data('image');
            $('#fullImage').attr('src', nextImageSrc);
        }
    });

    // Navigation vers la photo précédente
    $('#prevBtn').on('click', function() {
        var currentImage = $('#fullImage').attr('src');
        var currentIndex = -1;
        // Trouver l'index de l'image actuelle dans la liste des posts
        $('.post-link').each(function(index) {
            if ($(this).data('image') === currentImage) {
                currentIndex = index;
                return false; // Arrêter la boucle
            }
        });
        // Passer à l'image précédente si elle existe
        if (currentIndex !== -1 && currentIndex > 0) {
            var prevImageSrc = $('.post-link').eq(currentIndex - 1).data('image');
            $('#fullImage').attr('src', prevImageSrc);
        }
    });
});
</script>

@endsection
