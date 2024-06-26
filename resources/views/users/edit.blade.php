@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modifier utilisateur') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">{{ __('Nom') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="is_admin">{{ __('Admin') }}</label>
                            <select id="is_admin" class="form-control @error('is_admin') is-invalid @enderror" name="is_admin" required>
                                <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>Non</option>
                                <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Oui</option>
                            </select>

                            @error('is_admin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">{{ __('Status') }}</label>
                            <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                            </select>

                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Enregistrer les modifications') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
