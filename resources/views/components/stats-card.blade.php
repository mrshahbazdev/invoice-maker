@props(['title', 'value', 'icon', 'color'])

<div class="adm-card adm-stat">
    <div class="flex items-center justify-between">
        <div>
            <p class="adm-stat-label">{{ $title }}</p>
            <p class="adm-stat-value">{{ $value }}</p>
        </div>
        <div class="adm-stat-icon bg-{{ $color }}-50 border border-{{ $color }}-100 text-{{ $color }}-600">
            {!! $icon !!}
        </div>
    </div>
    <div class="adm-stat-glow"></div>
</div>
