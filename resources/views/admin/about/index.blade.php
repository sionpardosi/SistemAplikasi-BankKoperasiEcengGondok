@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="flex justify-between items-center mb-4">
            <h3>Daftar Tentang Kami</h3>
            <a href="{{ route('admin.about.create') }}" class="btn btn-primary">
                <i class="icon-plus"></i> Tambah Baru
            </a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Founder</th>
                    <th>Berdiri</th>
                    <th>Status</th>
                    <th>Gambar 1</th> {{-- new --}}
                    <th>Gambar 2</th> {{-- new --}}
                    <th>Map</th> {{-- baru --}}
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($abouts as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($abouts->currentPage() - 1) * $abouts->perPage() }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->founder ?? '-' }}</td>
                        <td>{{ optional($item->established_date)->format('Y') ?? '-' }}</td>
                        <td>
                            @if ($item->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Nonaktif</span>
                            @endif
                        </td>

                        {{-- Thumbnail Gambar 1 --}}
                        <td>
                            @if ($item->image1)
                                <img src="{{ asset($item->image1) }}" width="60" alt="{{ $item->image1_alt ?? '' }}">
                            @else
                                —
                            @endif
                        </td>

                        {{-- Thumbnail Gambar 2 --}}
                        <td>
                            @if ($item->image2)
                                <img src="{{ asset($item->image2) }}" width="60" alt="{{ $item->image1_alt ?? '' }}">
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if($item->map_embed)
                              <a href="#" data-bs-toggle="tooltip" data-bs-html="true"
                                 title="{{ Str::limit($item->map_embed, 50) }}">
                                 <i class="icon-map-pin text-primary"></i>
                              </a>
                            @else
                              —
                            @endif
                          </td>

                        <td>
                            <a href="{{ route('admin.about.edit', $item) }}" class="btn btn-sm btn-warning">
                                <i class="icon-edit"></i>
                            </a>
                            <form action="{{ route('admin.about.destroy', $item) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin hapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="icon-trash-2"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $abouts->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
