  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

               <li class="nav-item has-treeview {{ (request()->is('admin/adminpanelsetting*') || request()->is('admin/treasures*') )? 'menu-open' : '' }} ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    <p>
                        الضبط العام
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.adminPanelsetting.index') }}" class="nav-link {{ (request()->is('admin/adminpanelsetting*'))? 'active' : '' }}">
                          <p>
                            الضبط العام
                          </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('admin.treasures.index') }}" class="nav-link {{ (request()->is('admin/treasures*'))? 'active' : '' }}">
                          <p>
                            بيانات الخزن
                          </p>
                        </a>
                      </li>
                </ul>
               </li>
               <li class="nav-item has-treeview {{ (request()->is('admin/adminpanelsetting*') || request()->is('admin/treasures*') )? 'menu-open' : '' }} ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    <p>
                         الحسابات
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                </ul>
               </li>

               <li class="nav-item has-treeview {{ (request()->is('admin/sales_materials_types*') || request()->is('admin/inv_itemcard_categories*')  || request()->is('admin/itemCard*')||request()->is('admin/uoms*') || request()->is('admin/stores*') )? 'menu-open' : '' }} ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    <p>
                        ضبط المخازن
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.sales_materials_types.index') }}" class="nav-link {{ (request()->is('admin/sales_materials_types*'))? 'active' : '' }}">
                          *
                          <p>
                            بيانات فئات الفواتير
                          </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('admin.stores.index') }}" class="nav-link {{ (request()->is('admin/stores*'))? 'active' : '' }}">
                          *
                          <p>
                            بيانات المخازن
                          </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('admin.uoms.index') }}" class="nav-link {{ (request()->is('admin/uoms*'))? 'active' : '' }}">
                          *
                          <p>
                            بيانات الوحدات
                          </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('inv_itemcard_categories.index') }}" class="nav-link {{ (request()->is('admin/inv_itemcard_categories*'))? 'active' : '' }}">
                          *
                          <p>
                             فئات الاصناف
                          </p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('admin.itemCard.index') }}" class="nav-link {{ (request()->is('admin/itemCard*'))? 'active' : '' }}">
                          *
                          <p>
                              الاصناف
                          </p>
                        </a>
                      </li>

                </ul>
               </li>
               <li class="nav-item has-treeview {{ (request()->is('admin/adminpanelsetting*') || request()->is('admin/treasures*') )? 'menu-open' : '' }} ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    <p>
                         حركات مخزنية
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                </ul>
               </li>

               <li class="nav-item has-treeview {{ (request()->is('admin/adminpanelsetting*') || request()->is('admin/treasures*') )? 'menu-open' : '' }} ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    <p>
                         المبيعات
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                </ul>
               </li>
               <li class="nav-item has-treeview {{ (request()->is('admin/adminpanelsetting*') || request()->is('admin/treasures*') )? 'menu-open' : '' }} ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    <p>
                         خدمات داخلية و خارجية
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                </ul>
               </li>

               <li class="nav-item has-treeview {{ (request()->is('admin/adminpanelsetting*') || request()->is('admin/treasures*') )? 'menu-open' : '' }} ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    <p>
                        حركة شفت الخزينة
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                </ul>
               </li>
               <li class="nav-item has-treeview {{ (request()->is('admin/adminpanelsetting*') || request()->is('admin/treasures*') )? 'menu-open' : '' }} ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    <p>
                    الصلاحيات
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                </ul>
               </li>
               <li class="nav-item has-treeview {{ (request()->is('admin/adminpanelsetting*') || request()->is('admin/treasures*') )? 'menu-open' : '' }} ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    <p>
                          التقارير
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                </ul>
               </li>
               <li class="nav-item has-treeview {{ (request()->is('admin/adminpanelsetting*') || request()->is('admin/treasures*') )? 'menu-open' : '' }} ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    <p>
                          المراقبة و الدعم الفنى
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                </ul>
               </li>
        </ul>
    </aside>
