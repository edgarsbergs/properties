@for($i = 1; $i <= $max_value; $i++)

    <option value="{{ $i }}"
        @if($current_value == $i)
            selected
        @endif
    >{{ $i }}</option>

@endfor
