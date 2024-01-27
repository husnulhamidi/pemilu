@php
	$direction = config('layout.extras.user.offcanvas.direction', 'right');
@endphp
 {{-- User Panel --}}
<div id="kt_quick_user" class="offcanvas offcanvas-{{ $direction }} p-10">
	{{-- Header --}}
	{{-- <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
		<h3 class="font-weight-bold m-0">
			<small class="text-muted font-size-sm ml-2">12 messages</small>
		</h3>
		<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
			<i class="ki ki-close icon-xs text-muted"></i>
		</a>
	</div> --}}

	{{-- Content --}}
    <div class="offcanvas-content pr-5 mr-n5">
		{{-- Header --}}
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="background-image:url('{{ asset('media/users/blank.png') }}')"></div>
				<i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">
					{{ Auth::user()->name }}
				</a>
                <div class="text-muted mt-1">
                    {{-- Application Developer --}}
					{{session('role', 'User')}}
                </div>
                <div class="navi mt-2">
					<form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link style="margin-left:-9px;" :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>

		{{-- Separator --}}
		<div class="separator separator-dashed mt-8 mb-5"></div>

		{{-- Nav --}}
		<div class="navi navi-spacer-x-0 p-0">
		    {{-- Item --}}
		    <a href="{{ route('profile') }}" class="navi-item">
		        <div class="navi-link">
		            <div class="symbol symbol-40 bg-light mr-3">
		                <div class="symbol-label">
							{{ Metronic::getSVG("media/svg/icons/General/Notification2.svg", "svg-icon-md svg-icon-success") }}
						</div>
		            </div>
		            <div class="navi-text">
		                <div class="font-weight-bold">
		                    Profil
		                </div>
		                <div class="text-muted">
		                    Update Akun
		                    {{-- <span class="label label-light-danger label-inline font-weight-bold">update</span> --}}
		                </div>
		            </div>
		        </div>
		    </a>

			 {{-- Item --}}
		   
			

		    {{-- Item --}}
		    {{-- <a href="#"  class="navi-item">
		        <div class="navi-link">
					<div class="symbol symbol-40 bg-light mr-3">
						<div class="symbol-label">
 						   {{ Metronic::getSVG("media/svg/icons/Shopping/Chart-bar1.svg", "svg-icon-md svg-icon-warning") }}
 					   </div>
				   	</div>
		            <div class="navi-text">
		                <div class="font-weight-bold">
		                    My Messages
		                </div>
		                <div class="text-muted">
		                    Inbox and tasks
		                </div>
		            </div>
		        </div>
		    </a> --}}

		    {{-- Item --}}
		    {{-- <a href="#" class="navi-item">
		        <div class="navi-link">
					<div class="symbol symbol-40 bg-light mr-3">
						<div class="symbol-label">
							{{ Metronic::getSVG("media/svg/icons/Communication/Mail-opened.svg", "svg-icon-md svg-icon-primary") }}
						</div>
				   	</div>
		            <div class="navi-text">
		                <div class="font-weight-bold">
		                    My Tasks
		                </div>
		                <div class="text-muted">
		                    latest tasks and projects
		                </div>
		            </div>
		        </div>
		    </a> --}}
		</div>

		
    </div>
</div>
