@props([
    'menus' => [],
])

<div id="kt_app_sidebar" class="app-sidebar flex-column drawer drawer-start bg-cyan bg-gradient" data-kt-drawer="true"
    data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6 d-flex align-items-center justify-content-center gap-4" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="/dashboard" class="bg-light p-1 px-4 rounded">
            <img src="{{ asset('images/logo/Logo-magetan.jpg') }}" alt="World Games" class="h-50px app-sidebar-logo-default">
            <img src="{{ asset('images/logo/Logo-magetan.jpg') }}" alt="World Games" class="h-10px app-sidebar-logo-minimize">
        </a>
        <div class="h-50px app-sidebar-logo-default fw-bold text-light fs-4">Event Management</div>
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->

    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <!--begin::Scroll wrapper-->
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    <!--begin:Menu item-->

                    @foreach ($menus as $menu)
                        @php
                            $currentUrl = url()->current();
                            $menuUrl = url($menu->url);
                            $isActive = $currentUrl == $menuUrl;
                        @endphp

                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            @if ($menu->childrens->isEmpty())
                                <div class="menu-item">
                                    <!--begin:Menu link-->
                                    <a class="menu-link text-hover-dark {{ $isActive ? 'active' : '' }}"
                                        href="{{ $menu->url }}">
                                        <span class="menu-icon fw-bolder">
                                            <i class="{{ $menu->icon }} {{ $isActive ? 'text-dark' : 'text-light' }}">
                                            </i>
                                        </span>
                                        <span class="menu-title fw-bolder text-hover-dark {{ $isActive ? 'text-dark' : 'text-light' }}">{{ $menu->name }}</span>
                                    </a>
                                    <!--end:Menu link-->
                                </div>
                            @else
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="{{ $menu->icon }}">
                                        </i>
                                    </span>
                                    <span class="menu-title {{ $isActive ? 'active' : '' }}">{{ $menu->name }}</span>
                                    <span class="menu-arrow"></span>
                                </span>

                                <div class="menu-sub menu-sub-accordion">
                                    @foreach ($menu->childrens as $child)
                                        @php
                                            $childUrl = url($child->url);
                                            $isChildActive = $currentUrl == $childUrl;
                                        @endphp

                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link {{ $isChildActive ? 'active' : '' }}"
                                                href="{{ $child->url }}">
                                                <span class="menu-icon">
                                                    <i class="{{ $child->icon }}">
                                                    </i>
                                                </span>
                                                <span class="menu-title">{{ $child->name }}</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    @endforeach
                                </div>
                            @endif
                            <!--end:Menu sub-->
                        </div>
                    @endforeach
                    <!--end:Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Scroll wrapper-->
        </div>
        <!--end::Menu wrapper-->
    </div>
</div>