@php
    $key = $field['key'];
    $value = $item ? data_get($item, $key) : old($key);
    $type = $field['type'] ?? 'text';
    $inputType = $type === 'date' ? 'date' : ($type === 'datetime' ? 'datetime-local' : $type);
    if ($value instanceof \Carbon\CarbonInterface) {
        $value = $type === 'datetime' ? $value->format('Y-m-d\\TH:i') : $value->format('Y-m-d');
    }
    $class = $field['full'] ?? false ? 'full-width' : '';
@endphp
<div class="{{ $class }}">
    <label class="form-label fw-semibold"
        for="{{ $key }}{{ $item?->id ?? 'create' }}">{{ $field['label'] }}</label>
    @if ($type === 'select')
        <select name="{{ $key }}" id="{{ $key }}{{ $item?->id ?? 'create' }}" class="form-select"
            {{ $field['required'] ?? false ? 'required' : '' }}>
            @if (!($field['required'] ?? false))
                <option value="">-- Aucun --</option>
            @endif
            @foreach ($fieldOptions($field) as $option)
                @php
                    $optionValue = is_array($option) ? $option['value'] ?? '' : $option->id ?? $option;
                    $optionLabel = is_array($option)
                        ? $option['label'] ?? $optionValue
                        : match ($field['options'] ?? null) {
                            'annees' => $option->annee,
                            'services' => trim(
                                $option->nom_service . ($option->domaine ? ' - ' . $option->domaine : ''),
                            ),
                            'users' => trim($option->name . ($option->role ? ' - ' . $option->role : '')),
                            'employes' => trim($option->nom . ($option->matricule ? ' - ' . $option->matricule : '')),
                            default => $option->nom ??
                                ($option->nom_service ??
                                    ($option->designation ?? ($option->intitule ?? ($option->name ?? $optionValue)))),
                        };
                @endphp
                <option value="{{ $optionValue }}" {{ (string) $value === (string) $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    @elseif ($type === 'textarea')
        <textarea name="{{ $key }}" id="{{ $key }}{{ $item?->id ?? 'create' }}" class="form-control"
            rows="3" {{ $field['required'] ?? false ? 'required' : '' }}>{{ $value }}</textarea>
    @elseif ($type === 'checkbox')
        <div class="form-check form-switch pt-2">
            <input type="hidden" name="{{ $key }}" value="0">
            <input type="checkbox" name="{{ $key }}" id="{{ $key }}{{ $item?->id ?? 'create' }}"
                class="form-check-input" value="1"
                {{ filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $key }}{{ $item?->id ?? 'create' }}">Actif</label>
        </div>
    @else
        <input type="{{ $inputType }}" name="{{ $key }}"
            id="{{ $key }}{{ $item?->id ?? 'create' }}" class="form-control"
            value="{{ $type === 'file' ? '' : $value }}"
            {{ ($field['required'] ?? false) && !$item ? 'required' : '' }}
            {{ isset($field['step']) ? 'step=' . $field['step'] : '' }}
            {{ isset($field['min']) ? 'min=' . $field['min'] : '' }}>
        @if ($type === 'file' && $item)
            <small class="text-muted">Laisser vide pour conserver le fichier actuel.</small>
        @endif
    @endif
</div>
