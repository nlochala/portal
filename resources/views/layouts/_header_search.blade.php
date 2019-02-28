<div id="page-header-search" class="overlay-header bg-primary">
    <div class="content-header">
        <form class="w-100" action="/dashboard" method="POST">
            @csrf
            <div class="input-group">
                <div class="input-group-prepend">
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-primary" data-toggle="layout" data-action="header_search_off">
                        <i class="fa fa-fw fa-times-circle"></i>
                    </button>
                </div>
                <input type="text" class="form-control border-0" placeholder="Search or hit ESC.." id="page-header-search-input" name="page-header-search-input">
            </div>
        </form>
    </div>
</div>