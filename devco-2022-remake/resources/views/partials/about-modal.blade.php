<!-- About Modal -->
<div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel">About DevCo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h3 class="mb-3">DevCo</h3>
                <p class="small text-muted mb-2"><em>Damn, Everyone's Vibing Community</em></p>
                <p class="text-muted mb-3">A modern social media platform to connect with friends and share your
                    thoughts.</p>
                <div class="mb-3">
                    @php
                        $latestUpdate = \App\Models\Update::latest()->first();
                        $version = $latestUpdate?->version ?? '1.0.0';
                    @endphp
                    <p class="mb-1"><strong>Version:</strong> {{ $version }}</p>
                    <p class="mb-3"><strong>Developed by:</strong> <a href="https://houselab.my.id"
                            target="_blank">houselab.my.id</a></p>
                </div>
                <hr>
                <p class="small text-muted">&copy; 2022 Houselab. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>
