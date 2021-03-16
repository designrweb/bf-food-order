<li class="nav-item d-flex align-items-center" id="consumer-switcher-page" style="min-height: 70px">
    <consumer-switcher
            main_route="/user/consumers"
            :consumers="{{ json_encode($consumersList) }}"
            :selected_consumer="{{ json_encode($selectedConsumer) }}"
    ></consumer-switcher>
</li>

<script src="{{ ('/js/crud/consumer_switcher.js') }}"></script>



