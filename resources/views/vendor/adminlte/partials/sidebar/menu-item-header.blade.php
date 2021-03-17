@if (isset($item['line']) && $item['line'])
    <li>
        <hr>
    </li>
@else
    <li @if(isset($item['id'])) id="{{ $item['id'] }}" @endif class="nav-header {{ $item['class'] ?? '' }}">
        {{ is_string($item) ? $item : $item['header'] }}
    </li>
@endif
