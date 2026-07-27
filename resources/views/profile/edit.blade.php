@extends('app')

@section('content')
<div class="mb-6">
    <h1 class="page-heading">Profil Saya</h1>
    <p class="text-muted mt-1 text-body-sm">Kelola informasi akun dan keamanan Anda.</p>
</div>

<div class="max-w-3xl space-y-6">
    <div class="card">
        <div class="card-body">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
