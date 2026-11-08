@if (session('aviso'))
    <div class="alert alert-warning mt-3" role="status">
        <i class="fas fa-lock mr-1"></i> {{ session('aviso') }}
    </div>
@endif
