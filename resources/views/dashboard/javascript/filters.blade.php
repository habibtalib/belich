{{-- Javascript Search --}}
<script>
    /**
    ****************************************
    * Index javascript filters methods
    ****************************************
    */
    //Default separator
    window._separator = '***';

   /*
   Section: Search
   Description: Live filter
   */
   function liveFilter()
   {
       // Set default values
       window.liveSearch(
           '{{ Belich::key() }}',
           document.getElementById('live_search_query').value,
           document.getElementById('live_search_page').value,
           document.getElementById('live_search_order').value,
           document.getElementById('live_search_direction').value,
           document.getElementById('live_search_filters').value,
           true
       );
   }

   /*
   Section: Filter
   Description: get all the filters
   */
   function getFilters(separator = '***')
   {
       var filters = [];
       // Regular filters
       var selects = document.querySelectorAll('select.search-live-filter');
       for (var i = 0; i < selects.length; i++)  {
            var value = selects[i].value;
            if(value) {
                filters.push(
                    selects[i].dataset.filter +
                    separator +
                    selects[i].id  +
                    separator +
                    value
                );
            }
       }
       // Date filters
       var selectsDate = document.querySelectorAll('div.search-live-filter-date');
       for (var i = 0; i < selectsDate.length; i++)  {
            var inputs = selectsDate[i].querySelectorAll('input');
            var dataset = selectsDate[i].dataset;
            filters = window.dateFilter(
                inputs[0].value,
                inputs[1].value,
                dataset.format,
                dataset.table,
                separator,
                filters
            );
       }

       return filters || document.getElementById('live_search_filters').value;
   }

   /*
   Section: Search
   Description: Add reset value for search if needed...
   */
   function dateFilter(start, end, format, table, separator, filters)
   {
        filters.push(
            'date' +
            separator +
            start  +
            separator +
            end +
            separator +
            format +
            separator +
            table
        );

        return filters;
   }
</script>
