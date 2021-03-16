<li class="nav-item" id="consumer-switcher-page">
    <consumer-switcher
            main_route="/user/consumers"
            :consumers="{{ json_encode($consumersList) }}"
            :selected_consumer="{{ json_encode($selectedConsumer) }}"
    ></consumer-switcher>
</li>

<script src="{{ ('/js/crud/consumer_switcher.js') }}"></script>



