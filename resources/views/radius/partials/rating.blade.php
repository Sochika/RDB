<!-- partials/rating.blade.php -->
<div class="rating">
  @for ($i = 5; $i >= 1; $i--)
      <input type="radio" id="{{ $name }}_star{{ $i }}" name="{{ $name }}" value="{{ $i }}"
          @if (isset($value) && $value == $i) checked @endif />
      <label for="{{ $name }}_star{{ $i }}" title="{{ $i }} stars">★</label>
  @endfor
</div>
