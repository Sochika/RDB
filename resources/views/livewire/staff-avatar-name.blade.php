<!-- resources/views/components/avatar-name.blade.php -->
<div class="d-flex align-items-center">
  <img src="{{ $avatar }}" alt="{{ $firstName }} {{ $lastName }}" class="avatar img-fluid rounded-circle me-2" style="width: 40px; height: 40px;">
  <span>{{ $firstName }} {{ $lastName }}</span>
</div>
