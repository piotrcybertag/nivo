@php
    $vPath = public_path('icons/nivo-32.png');
    $faviconV = (int) ((is_readable($vPath) ? @filemtime($vPath) : null) ?: @filemtime(public_path('nivo-favicon.ico')) ?: 0);
    $icon32 = url('/icons/nivo-32.png').'?v='.$faviconV;
    $icon16 = url('/icons/nivo-16.png').'?v='.$faviconV;
    $touch = url('/apple-touch-icon.png').'?v='.$faviconV;
    $ua = (string) request()->header('User-Agent', '');
    $likelySafariDesktop = str_contains($ua, 'Safari/')
        && ! preg_match('/Chrome|Chromium|Edg\\//i', $ua)
        && ! str_contains($ua, 'Firefox/');
@endphp
<link rel="icon" type="image/png" sizes="32x32" href="{{ $icon32 }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ $icon16 }}">
<link rel="apple-touch-icon" href="{{ $touch }}">
@if($likelySafariDesktop)
<script>
(function () {
  var u = @json($icon32);
  var sep = u.indexOf('?') === -1 ? '?' : '&';
  var href = u + sep + 'r=' + Date.now();
  var link = document.createElement('link');
  link.rel = 'icon';
  link.type = 'image/png';
  link.sizes = '32x32';
  link.href = href;
  document.head.appendChild(link);
  var s = document.createElement('link');
  s.rel = 'shortcut icon';
  s.type = 'image/png';
  s.href = href;
  document.head.appendChild(s);
})();
</script>
@endif
