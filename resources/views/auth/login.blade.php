@extends('layouts.app')

@section('title', 'Logowanie')

@section('content')
    <div style="max-width: 360px; margin: 2rem auto; padding: 1.5rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border: 1px solid #e5e7eb;">
        <h1 style="margin: 0 0 1.25rem; font-size: 1.25rem;">Logowanie</h1>

        @if (session('success'))
            <p style="padding: 0.5rem 0.75rem; background: #d1fae8; color: #065f46; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem;">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <p style="padding: 0.5rem 0.75rem; background: #fee2e2; color: #991b1b; border-radius: 0.375rem; margin-bottom: 1rem; font-size: 0.875rem;">
                {{ $errors->first() }}
            </p>
        @endif

        <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            <div>
                <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem;">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; box-sizing: border-box;">
            </div>
            <div>
                <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem;">Hasło</label>
                <input type="password" name="password" id="password" required
                    style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 1rem; box-sizing: border-box;">
            </div>
            <button type="submit" style="padding: 0.5rem 1rem; background: #1e40af; color: #fff; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; font-size: 1rem;">Zaloguj</button>
        </form>
    </div>
@endsection
