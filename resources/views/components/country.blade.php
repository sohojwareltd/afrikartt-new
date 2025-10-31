<select class="bg-light form-select form-control mx-0 border  @error('country') is-invalid @enderror" name="country"
    id="country" value="{{ auth()->user()->shop ? auth()->user()->shop->country : ' ' }}" required>
    <option selected>Choose Country</option>
    @if (auth()->user()->shop)
        <option {{ auth()->user()->shop->country == 'South Africa' ? 'selected' : '' }}>South Africa</option>
    @else
        <option value="nigeria">Nigeria</option>
        <option value="kenya">Kenya</option>
        <option value="south_africa">South Africa</option>
        <option value="egypt">Egypt</option>
        <option value="ghana">Ghana</option>
        <option value="ethiopia">Ethiopia</option>
        <option value="morocco">Morocco</option>
        <option value="uganda">Uganda</option>
    @endif
</select>
@error('country')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
