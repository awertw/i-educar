<?php
define('HOST', isset($_SERVER['HTTP_HOST']) === true ? $_SERVER['HTTP_HOST'] : (isset($_SERVER['SERVER_ADDR']) === true ? $_SERVER['SERVER_ADDR'] : $_SERVER['SERVER_NAME']));
$domain_parts = explode('.', HOST);
$corTecsis = "style='color: rgb(243, 135, 42)'";

if (isset($domain_parts[2]) != 'tec') {
    $corTecsis = "style='color: #2ab1e8'";
}
?>

<div class="Mobile-button">
    {{-- <input type="checkbox" id="expandido"> --}}
    <button class="expandir-btn" onclick="toogleMenu()"><i class="fa fa-bars" <?= $corTecsis ?>></i></button>
</div>
<div class="comprimido" id="menu">
    <ul class="ieducar-sidebar-menu">
        <div id="ieducar-quick-search" class="ieducar-quick-search">
            <h4 class="ieducar-quick-search-title">Busca rápida</h4>
            <quick-search></quick-search>
        </div>
        @foreach ($menu as $item)
            @if ($item->hasLinkInSubmenu())
                <li>
                    <a href="{{ $item->link }}"><i class="fa {{ $item->icon }}" <?= $corTecsis ?>></i>
                        <span>{{ $item->title }}</span></a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
<script>
    function toogleMenu() {

        document.getElementById('menu').classList.toggle('expandido');
    }
</script>
