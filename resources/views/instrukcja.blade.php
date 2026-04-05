@extends('layouts.app')

@section('title', __('manual.page_title'))

@section('content')
    <div style="max-width: 52rem; margin: 0 auto;">
        <h1 style="font-size: 1.75rem; font-weight: 600; color: #111; margin-bottom: 1.5rem;">{{ __('manual.main_heading') }}</h1>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">{{ __('manual.s1_title') }}</h2>
            <p style="line-height: 1.6; color: #374151;">
                {!! __('manual.s1_body') !!}
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">{{ __('manual.s2_title') }}</h2>
            <p style="line-height: 1.6; color: #374151;">
                {!! __('manual.s2_body') !!}
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">{{ __('manual.s3_title') }}</h2>
            <p style="line-height: 1.6; color: #374151;">
                {!! __('manual.s3_body') !!}
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">{{ __('manual.s4_title') }}</h2>
            <p style="line-height: 1.6; color: #374151;">
                {!! __('manual.s4_body') !!}
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">{{ __('manual.s5_title') }}</h2>
            <p style="line-height: 1.6; color: #374151;">
                {!! __('manual.s5_body') !!}
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">{{ __('manual.s6_title') }}</h2>
            <p style="line-height: 1.6; color: #374151;">
                {!! __('manual.s6_body') !!}
            </p>
        </section>

        <section style="margin-bottom: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">{{ __('manual.s7_title') }}</h2>
            <p style="line-height: 1.6; color: #374151;">
                {!! __('manual.s7_p1') !!}
            </p>
            <p style="line-height: 1.6; color: #374151;">
                <strong>{{ __('manual.s7_p2_title') }}</strong> {!! __('manual.s7_p2') !!}
            </p>
            <p style="line-height: 1.6; color: #374151;">
                <strong>{{ __('manual.s7_p3_title') }}</strong> {{ __('manual.s7_p3') }}
            </p>
        </section>
    </div>
@endsection
