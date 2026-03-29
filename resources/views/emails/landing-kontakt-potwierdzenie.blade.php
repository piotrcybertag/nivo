<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('landing.email_confirm.document_title') }}</title>
</head>
<body style="margin:0;font-family:system-ui,sans-serif;background:#f8fafc;color:#0f172a;line-height:1.5;">
<div style="max-width:560px;margin:0 auto;padding:24px 16px 40px;">
    <div style="text-align:center;margin-bottom:20px;">
        <img src="{{ $logoUrl }}" alt="Nivo" width="48" height="48" style="height:48px;width:auto;">
    </div>
    <h1 style="font-size:20px;margin:0 0 12px;">{{ __('landing.email_confirm.lead', ['name' => $name]) }}</h1>
    <p style="font-size:15px;margin:0 0 16px;">{{ __('landing.email_confirm.intro') }}</p>
    <p style="font-size:13px;font-weight:600;margin:0 0 6px;">{{ __('landing.email_confirm.message_label') }}</p>
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:8px;padding:12px 14px;font-size:14px;white-space:pre-wrap;">{{ $message }}</div>
    <p style="font-size:13px;color:#64748b;margin:20px 0 0;">{{ __('landing.email_confirm.no_reply') }}</p>
    <p style="font-size:14px;margin:24px 0 0;">{{ __('landing.email_confirm.signoff') }}<br>{{ __('landing.email_confirm.team') }}</p>
    <p style="font-size:12px;color:#94a3b8;margin:24px 0 0;">{{ $footerHost }} · {{ __('landing.email_confirm.footer_line') }}</p>
</div>
</body>
</html>
