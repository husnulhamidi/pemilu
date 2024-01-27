@if (config('layout.extras.cart.dropdown.style') == 'light')
    {{-- Header --}}
    <div class="d-flex align-items-center p-10 rounded-top bg-light">
        <span class="btn btn-md btn-icon bg-light-success mr-4">
            <i class="flaticon-map text-success"></i>
        </span>
        <h4 class="flex-grow-1 m-0 mr-3">Role User</h4>
        {{-- <button type="button" class="btn btn-success btn-sm">2 Items</button> --}}
    </div>
@else
    {{-- Header --}}
    <div class="d-flex align-items-center py-10 px-8 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url('{{ asset('media/misc/bg-1.jpg') }}')">
        <span class="btn btn-md btn-icon bg-white-o-15 mr-4">
            <i class="flaticon-map text-success"></i>
        </span>
        <h4 class="text-white m-0 flex-grow-1 mr-3">Role User</h4>
        {{-- <button type="button" class="btn btn-success btn-sm">2 Items</button> --}}
    </div>
@endif

{{-- Content --}}
<div class="tab-content">
    {{-- Tabpane --}}
    

    

  
</div>
