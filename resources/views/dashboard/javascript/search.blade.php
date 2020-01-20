{{-- Javascript Search --}}
<script>
    //Default javascript values
    window.window.minSearch = {{ config('belich.liveSearch.minChars') ?? 1 }};
    window.liveSearchRoute = '{{ route('dashboard.ajax.search') }}';
    window.liveSearchFields = '{{ Helper::searchFields() }}';

    /**
    ****************************************
    * Index javascript search methods
    ****************************************
    */

   /*
   Section: Search
   Description: Live search
   */
   function liveSearch(key, query = '', page = 1, orderBy = '', direction = '', filters = '', forceQuery = false) {
       // No filters
       if(forceQuery === false) {
           // Hide icon
           if(query.length === 0 || query === '') {
               window.onSelection('#icon-search-reset-' + key, 'hide');
           }
           // Min. search filter
           if(query.length < window.minSearch && query.length > 0) {
               return;
           }
       }
       // Get value
       var querySearch = window.querySearch(query);
       // Uncheck all the table items
       window.uncheckAll();
       // Loading
       document.getElementById('loading').classList.remove('hidden');
       // Get filters
       var filters = JSON.stringify(getFilters());
       // Set default values
       document.getElementById('live_search_query').value = query;
       document.getElementById('live_search_page').value = page;
       document.getElementById('live_search_order').value = orderBy;
       document.getElementById('live_search_direction').value = direction;
       document.getElementById('live_search_filters').value = filters;
       // Ajax request
       var request = new XMLHttpRequest();
       request.open('GET', '{{ route('dashboard.ajax.search') }}?type=search&tableTextAlign={{ $request->get('tableTextAlign') }}&query=' + querySearch + '&resourceName={{ Belich::resourceName() }}&fields={{ Helper::searchFields() }}&page=' + page + '&orderBy=' + orderBy + '&direction=' + direction + '&filters=' + filters, true);
       request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
       request.onload = function() {
           if (this.status == 200 && this.readyState == 4) {
               document.getElementById('index-table-' + key).innerHTML = JSON.parse(this.response);
               document.getElementById('loading').classList.add('hidden');
           }
       };
       request.send();
   }

   /*
   Section: Search
   Description: Add reset value for search if needed...
   */
   function querySearch(query = '')
   {
       return query.length <= 0
           ? 'resetSearchAll'
           : query;
   }

    /*
    Section: Search
    Description: Empty the input value when click on reset icon
    */
   function resetSearch(key)
   {
       //Reset value
       document.getElementById('search-' + key).value = '';

       //Hide icon
       window.onSelection('#icon-search-reset-' + key, 'hide');

       //Reset search
       window.liveSearch(key, 'resetSearchAll');
   }

    /*
    Section: Search
    Description: Show the reset icon when the input is not empty
    */
   function showResetSearch(key)
   {
       if(document.getElementById('search-' + key).value.length > 0) {
           window.onSelection('#icon-search-reset-' + key, 'show');
       }
   }
</script>
