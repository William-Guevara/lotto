{{-- Vendor JS Files --}}
{{--<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>--}}
<script src="{{ asset('js/datatables/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('js/typeahead/typeahead.bundle.js') }}"></script>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-sticky/jquery.sticky.js') }}"></script>
<script src="{{ asset('assets/vendor/venobox/venobox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/datatables/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>


{{-- Template Main JS File --}}
<script src="{{ asset('assets/js/main.js') }}"></script>

<script src="{{ asset('js/js_blade/modal_const.js') }}"></script>


{{-- Funcion para navegar desde el panel admin de loterias --}}
<script>
function getRouteLotto(category) {

    url = "{{ route('adminPurchase', ':category') }}";
    url = url.replace(':category', category);
    return url;
}

function getRouteLottoClient(category) {

url = "{{ route('browseProducts', ':category') }}";
url = url.replace(':category', category);
return url;
}
</script>