{{-- @php
    $states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'];
@endphp --}}

<select id="inputState" class="bg-light form-select form-control mx-0 border @error('state') is-invalid @enderror"
    value="{{ auth()->user()->shop ? auth()->user()->shop->state : ' ' }}" name="state" id="state" required>
    <option selected>Choose State</option>

    {{-- @foreach ($states as $state)
        @if (auth()->user()->shop)
            <option value="{{ $state }}" {{ auth()->user()->shop->state == $state ? 'selected' : '' }}>
                {{ $state }}</option>
        @else
            <option value="{{ $state }}">
                {{ $state }}</option>
        @endif
    @endforeach --}}


</select>
@error('state')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
