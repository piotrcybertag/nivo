@extends('layouts.app')

@section('title', __('users.page_title'))

@section('content')
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin: 0;">{{ __('users.heading') }}</h1>
        <a href="{{ \App\Support\AppUrl::route('kartoteki.uzytkownicy.create') }}" style="display: inline-block; padding: 0.5rem 1rem; background: #1e40af; color: #fff; text-decoration: none; border-radius: 0.375rem; font-weight: 500;">{{ __('users.add_user') }}</a>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 0.5rem;">
            <thead>
                <tr style="background: #f3f4f6; border-bottom: 2px solid #e5e7eb;">
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">{{ __('users.th_id') }}</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">{{ __('users.th_email') }}</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">{{ __('users.th_full_name') }}</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">{{ __('users.th_type') }}</th>
                    <th style="text-align: left; padding: 0.75rem 1rem; font-weight: 600;">{{ __('users.th_plan') }}</th>
                    <th style="text-align: right; padding: 0.75rem 1rem; font-weight: 600;">{{ __('users.th_actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($uzytkownicy as $u)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 0.75rem 1rem;">{{ $u->id }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $u->email }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $u->imie_nazwisko }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $u->typ }}</td>
                        <td style="padding: 0.75rem 1rem;">{{ $u->plan ?? __('users.emdash') }}</td>
                        <td style="padding: 0.75rem 1rem; text-align: right;">
                            <a href="{{ \App\Support\AppUrl::route('kartoteki.uzytkownicy.show', $u) }}" style="color: #2563eb; text-decoration: none; margin-right: 0.5rem;">{{ __('users.details') }}</a>
                            <a href="{{ \App\Support\AppUrl::route('kartoteki.uzytkownicy.edit', $u) }}" style="color: #2563eb; text-decoration: none; margin-right: 0.5rem;">{{ __('users.edit') }}</a>
                            <form action="{{ \App\Support\AppUrl::route('kartoteki.uzytkownicy.destroy', $u) }}" method="POST" style="display: inline;" onsubmit="return confirm({{ json_encode(__('users.confirm_delete')) }});">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #dc2626; cursor: pointer; padding: 0;">{{ __('users.delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 2rem; text-align: center; color: #6b7280;">{{ __('users.empty') }} <a href="{{ \App\Support\AppUrl::route('kartoteki.uzytkownicy.create') }}" style="color: #2563eb;">{{ __('users.add_first') }}</a>.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($uzytkownicy->hasPages())
        <div style="margin-top: 1.5rem;">{{ $uzytkownicy->links() }}</div>
    @endif
@endsection
