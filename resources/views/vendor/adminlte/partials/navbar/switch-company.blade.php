<li class="nav-item" id="companies-switcher-page">
    <companies-switcher
            :main_route="'/admin/companies'"
            :companies_list="{{json_encode($companiesList)}}"
            :selected_company="{{json_encode($selectedCompany)}}"
    ></companies-switcher>
</li>

<script src="{{('/js/crud/companies_switcher.js')}}"></script>



