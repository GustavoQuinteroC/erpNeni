@if (session('aviso'))
    <div class="alert alert-warning mt-3" role="status">
        <i class="bi bi-lock me-1"></i> {{ session('aviso') }}
    </div>
@endif
