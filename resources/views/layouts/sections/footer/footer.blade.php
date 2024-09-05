@php
    $containerFooter =
        isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact'
            ? 'container-xxl'
            : 'container-fluid';
@endphp

<!-- Footer-->
<footer class="content-footer footer bg-footer-theme">
    <div class="{{ $containerFooter }}">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body">
                © Radius Security
                <script>
                    document.write(new Date().getFullYear())
                </script>, made with ❤️ by <a
                    href="{{ !empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : '' }}"
                    target="_blank"
                    class="footer-link">{{ !empty(config('variables.creatorName')) ? config('variables.creatorName') : '' }}</a>
            </div>
            {{-- <div class="d-none d-lg-inline-block">
        <a href="{{ config('variables.documentation') ? config('variables.documentation').'/laravel-introduction.html' : '#' }}" target="_blank" class="footer-link me-4">Documentation</a>
      </div> --}}
        </div>
    </div>
</footer>
<!--/ Footer-->
