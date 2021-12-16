<img
    src="{!!$message->embedData(QrCode::format('png')->generate($url), 'QrCode.png', 'image/png')!!}"
    alt="QrCode"
/>
<br>
<p>
    Download format SVG:<br>
    <a href="{{ route('export', ['uuid' => $uuid, 'type' => 'svg', 'size' => 'sm']) }}">SVG sm</a><br>
    <a href="{{ route('export', ['uuid' => $uuid, 'type' => 'svg', 'size' => 'md']) }}">SVG md</a><br>
    <a href="{{ route('export', ['uuid' => $uuid, 'type' => 'svg', 'size' => 'lg']) }}">SVG lg</a><br>
    <a href="{{ route('export', ['uuid' => $uuid, 'type' => 'svg', 'size' => 'xl']) }}">SVG xl</a><br>
</p>
<br>
<p>
    Download format PNG:<br>
    <a href="{{ route('export', ['uuid' => $uuid, 'type' => 'png', 'size' => 'sm']) }}">PNG sm</a><br>
    <a href="{{ route('export', ['uuid' => $uuid, 'type' => 'png', 'size' => 'md']) }}">PNG md</a><br>
    <a href="{{ route('export', ['uuid' => $uuid, 'type' => 'png', 'size' => 'lg']) }}">PNG lg</a><br>
    <a href="{{ route('export', ['uuid' => $uuid, 'type' => 'png', 'size' => 'xl']) }}">PNG xl</a><br>
</p>

Thanks,<br>
{{ config('app.name') }}
