@if ($bannerExists)
    <section class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="rounded-3 banner-bg-white">
                    <div class="">
                        <div class="row g-3">
                            <x-banner.home-end-four-card-one />
                            <x-banner.home-end-four-card-two />
                            <x-banner.home-end-four-card-three />
                            <x-banner.home-end-four-card-four />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
