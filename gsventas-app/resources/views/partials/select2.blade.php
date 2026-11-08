@props(['name', 'label', 'placeholder', 'options', 'selected'])

<div class="mb-3">
    <div class="input-group">
        <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
        <select class="form-select" name="{{ $name }}">
            <option value="">{{ $placeholder }}</option>
            @foreach ($options as $key => $value)
                @php
                    $isSelected = isset($selected) && $selected == $key;
                @endphp
                <option value="{{ $key }}" {{ $isSelected ? 'selected' : '' }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
    @error($name)
    <span class="text-danger small">{{ $message }}</span>
    @enderror
</div>
