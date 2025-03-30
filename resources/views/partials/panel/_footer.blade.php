<!-- Libs JS -->
<script src="{{ asset('assets') }}/dist/libs/apexcharts/dist/apexcharts.min.js?1684106062" defer></script>
<script src="{{ asset('assets') }}/dist/libs/litepicker/dist/litepicker.js?1684106062" defer></script>
<!-- Tabler Core -->
<script src="{{ asset('assets') }}/dist/js/tabler.min.js?1684106062" defer></script>
<script src="{{ asset('assets') }}/dist/js/demo.min.js?1684106062" defer></script>
<script src="https://cdn.jsdelivr.net/npm/simple-notify@1.0.4/dist/simple-notify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker.min.js"></script>
@if (Session::has('toast-text'))
<script>
    const toastStatus = '{{ Session::get("toast-status") }}';
    const toastTitle = '{{ Session::get("toast-title") }}';
    const toastText = '{{ Session::get("toast-text") }}';
    new Notify ({
        status: toastStatus,
        title: toastTitle,
        text: toastText,
        effect: 'fade',
        speed: 300,
        customClass: 'border-0',
        customIcon: '',
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 3000,
        notificationsGap: null,
        notificationsPadding: null,
        type: 'outline',
        position: 'right top',
        customWrapper: '',
    });
</script>
@endif
@stack('scripts')
</body>
</html>
