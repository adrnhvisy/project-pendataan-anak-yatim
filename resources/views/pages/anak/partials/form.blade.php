<div class="space-y-6">
    @include('pages.anak.partials.data-anak', ['anak' => $anak ?? null])
    @include('pages.anak.partials.data-alamat', ['anak' => $anak ?? null])
    @include('pages.anak.partials.data-orang-tua', ['anak' => $anak ?? null])
    @include('pages.anak.partials.data-wali', ['anak' => $anak ?? null])
    @include('pages.anak.partials.dokumen', ['anak' => $anak ?? null])
</div>