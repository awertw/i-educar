<<<<<<< HEAD
@if (isset($breadcrumb)  && $breadcrumb->getLegacy())
    {!! $breadcrumb->getLegacy() !!}
@elseif (isset($breadcrumb)  && $breadcrumb->currentPage())
    <div class="breadcrumb">
        <a href="{{ route('home') }}" title="Ir para o Início">
            <i class="fa fa-home" aria-hidden="true"></i><span> Início</span>
        </a>

        <a class="breadcrumb-separator"> / </a>

        @foreach ($breadcrumb->pages() as $page)
            <a href="{{ $page->link }}" title="{{ $page->label }}">{{ $page->label }}</a>
            <a class="breadcrumb-separator"> / </a>
        @endforeach

        <span class="breadcrumb-current">{{ $breadcrumb->currentPage() }}</span>

        @if ($breadcrumb->isBeta())
            <img src="{{ Asset::get('/img/beta.png') }}" class="beta-badge" title="Versão de testes">
        @endif

    </div>
@endif
=======
@if ($breadcrumb?->getLegacy())
    {!! $breadcrumb->getLegacy() !!}
@elseif ($breadcrumb?->currentPage())
    <div class="breadcrumb">
        <a href="{{ route('home') }}" title="Ir para o Início">
            <i class="fa fa-home" aria-hidden="true"></i><span> Início</span>
        </a>

        <a class="breadcrumb-separator"> / </a>

        @foreach ($breadcrumb->pages() as $page)
            <a href="{{ $page->link }}" title="{{ $page->label }}">{{ $page->label }}</a>
            <a class="breadcrumb-separator"> / </a>
        @endforeach

        <span class="breadcrumb-current">{{ $breadcrumb->currentPage() }}</span>

        @if ($breadcrumb->isBeta())
            <img src="{{ Asset::get('/img/beta.png') }}" class="beta-badge" title="Versão de testes">
        @endif

    </div>
@endif
>>>>>>> 0e43d46bd70bbf8f4ae92c2780080d51c6ccd837
