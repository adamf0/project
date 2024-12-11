<li class="nav-item dropdown">
    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number">{{ count($datas) }}</span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="height: 200px !important; overflow-y: scroll;">
        <x-top-nav-menu-dropdown-child-header title="You have {{ count($datas) }} new notifications" :desc="false"></x-top-nav-menu-dropdown-child-header>
        @foreach ($datas as $data)
        <x-top-nav-menu-dropdown-child icon="bi bi-info-circle-fill" class="text-info">
            <p>{{$data->isi}}</p>
            @if (!empty($data->file_url) && $data->file_url!="#")
            <a href="{{$data->file_url}}" class="btn btn-small btn-success">klik tautan</a>                
            @endif
        </x-top-nav-menu-dropdown-child>
        @endforeach
    </ul>
</li>