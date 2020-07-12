<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-thumbs-up"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-thumbs-down"></i> {{ session('error') }}
            </div>
        @endif
    </div>
</div>
