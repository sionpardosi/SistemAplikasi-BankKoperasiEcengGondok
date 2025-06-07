<!-- Sertakan SweetAlert2 (CDN) di layout/app.blade.php -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<ul class="account-nav">
    <li><a href="{{ route('user.index') }}"
            class="menu-link menu-link_us-s {{ request()->routeIs('user.index') ? 'active' : '' }}">Beranda Pengguna</a>
    </li>
    <li><a href="{{ route('user.account.orders') }}"
            class="menu-link menu-link_us-s {{ request()->routeIs('user.account.orders') ? 'active' : '' }}">Pesanan Saya</a></li>
    <li><a href="{{ route('user.account.supplier.request') }}"
            class="menu-link menu-link_us-s {{ request()->routeIs('user.account.supplier.request') ? 'active' : '' }}">Permintaan Pemasok</a>
    </li>
    <li><a href="{{ route('user.address.account-address') }}"
            class="menu-link menu-link_us-s {{ request()->routeIs('user.address.account-address') ? 'active' : '' }}">Daftar
            Alamat</a></li>
    <li><a href="{{ route('user.accountdetails.account-details') }}"
            class="menu-link menu-link_us-s {{ request()->routeIs('user.accountdetails.account-details') ? 'active' : '' }}">Detail Akun</a>
    </li>
    <li><a href="{{ route('wishlist.index') }}"
            class="menu-link menu-link_us-s {{ request()->is('wishlist.index') ? 'active' : '' }}">Favorit</a>
    </li>
    <li>
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <a href="#" class="menu-link menu-link_us-s" id="logout-button">Keluar</a>
        </form>
    </li>
</ul>

<style>
    /* Tambahkan CSS untuk tampilan menu aktif */
    .menu-link.active {
        color: #956a3b !important;
        /* Warna yang sama dengan icon di SweetAlert */
        font-weight: bold;
        position: relative;
    }

    /* Opsional: tambahkan indikator visual seperti garis bawah atau ikon */
    .menu-link.active::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #956a3b;
    }
</style>

<script>
    document.getElementById('logout-button').addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Konfirmasi Keluar',
            text: 'Apakah Anda yakin ingin keluar dari akun Anda?',
            icon: 'warning',
            iconColor: '#b9a16b',
            // gunakan icon default SweetAlert2
            showCancelButton: true,
            reverseButtons: true,
            focusCancel: true,
            confirmButtonText: 'Keluar',
            confirmButtonColor: '#e3342f', // destructive red
            cancelButtonText: 'Batal',
            cancelButtonColor: '#6c757d' // secondary neutral
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    });
</script>
