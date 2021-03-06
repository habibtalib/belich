{{-- Javascript default values --}}
<script>
    //Default javascript values
    window._path = window.location.origin;
    window.message_chart_left = '{{ trans('belich::forms.chart_left') }}';
    window.resourceName = '{{ Belich::resourceName() }}';

    /**
    ****************************************
    * Ajax javascript methods
    ****************************************
    */
    //Generate the validation request for AJAX
    function responseAjaxRequest(request) {
        return {
            method: 'POST',
            credentials: 'same-origin',
            body: request,
            headers: responseAjaxHeaders()
        };
    }

    //Get csrf-token
    function csrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }

    //Set the headers response
    function responseAjaxHeaders() {
        return {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": csrfToken()
        };
    }

    /**
    ****************************************
    * Default javascript methods
    ****************************************
    */
    // Load js script to head
    function loadScript(src, done) {
        var js = document.createElement('script');
        js.src = src;
        js.onload = function() {
            done();
        };
        js.onerror = function() {
            done(new Error('Failed to load script ' + src));
        };
        document.head.appendChild(js);
    }

    // browser support for fetch
    function browserSupportsFetch() {
        return window.Promise && window.fetch && window.Symbol;
    }

    // Loading button
    function loading(item, event) {
        item.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    }

    //Close alert with fadeOut
    function closeMenssage(container) {
        //Set container
        var container = document.getElementById('menssage-alert');
        //Set the opacity to 0
        container.style.opacity = '0';
        //Hide the div after 500ms
        setTimeout(function() {container.style.display = 'none';}, 500);
    }

    //Add attributes to elements
    function setAttributes(element, attrs) {
        for(var key in attrs) {
            if(key === 'value') {
                element.innerHTML = attrs[key];
            } else {
                element.setAttribute(key, attrs[key]);
            }
        }
    }

    // Show or hide a container
    function toogleContainer(container, value) {
        container.classList.remove('hidden', 'block');
        container.classList.add(value);
    }

    // String to kebad case
    function kebabCase(str = '') {
        if(!str || typeof str !== 'string') {
            return str;
        }
        const result = str.replace(
            /[A-Z\u00C0-\u00D6\u00D8-\u00DE]/g,
            match => '-' + match.toLowerCase()
        );
        return (str[0] === str[0].toUpperCase())
            ? result.substring(1)
            : result;
    }

     /*
     Section: Global
     Description: Toggle container base on item selection
     */
    function toggleOnSelection(selector, items) {
        (items.length <= 0) ? onSelection(selector, 'hide') : onSelection(selector, 'show');
    }

     /*
     Section: Global
     Description: Show or hide container base on item selection
     */
    function onSelection(selector, type)
    {
        var elements = document.querySelectorAll(selector);

        //Show each element
        for (var i = 0; i < elements.length; i++) {
            (type === 'hide')
                ? elements[i].classList.add('hidden')
                : elements[i].classList.remove('hidden');
        }
    }
</script>
