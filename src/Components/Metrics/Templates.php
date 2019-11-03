<?php

namespace Daguilarm\Belich\Components\Metrics;

trait Templates
{
    /*
    |--------------------------------------------------------------------------
    | Javascript templates for Graphs
    |--------------------------------------------------------------------------
    */

    /**
     * Template Line Graph
     *
     * @return string
     */
    private static function templateLineGraph() : string
    {
        return "new Chartist.Line('.%s', data_%s, %s);";
    }

    /**
     * Template Bar Graph options
     *
     * @return string
     */
    private static function templateBarGraph() : string
    {
        return "new Chartist.Bar('.%s', data_%s, %s);";
    }

    /**
     * Template Pie Graph
     *
     * @return string
     */
    private static function templatePieGraph() : string
    {
        return "new Chartist.Pie('.%s', data_%s, %s);";
    }

    /*
    |--------------------------------------------------------------------------
    | Javascript templates for options
    |--------------------------------------------------------------------------
    */

    /**
     * Template show area
     *
     * @return string
     */
    private static function templateLineGraphOptions() : string
    {
        return '{showArea:true,low:0,}';
        //     {
        //         showArea: true,
        //         low: 0,
        //     }
    }

    /**
     * Template Bar Graph options
     *
     * @return string
     */
    private static function templateBarGraphOptions() : string
    {
        return '{seriesBarDistance:10,axisX:{offset:30},seriesBarDistance:10,axisX:{offset: 30},axisY:{offset:40,labelInterpolationFnc:function(value){return value},scaleMinSpace: 15,}}';
            //{
            //     seriesBarDistance:10,
            //     axisX: {
            //         offset: 30
            //     },
            //     axisY: {
            //         offset: 40,
            //         labelInterpolationFnc: function(value) {
            //             return value
            //         },
            //         scaleMinSpace: 15,
            //     }
            // }
    }

    /**
     * Template Horizontal Bar Graph options
     *
     * @return string
     */
    private function templateHorizontalBarGraphOptions() : string
    {
        return '{reverseData:true,horizontalBars:true,seriesBarDistance:10,axisX:{offset:30},axisY:{offset:100,}}';
        //     {
        //         reverseData: true,
        //         horizontalBars: true,
        //         seriesBarDistance: 10,
        //         axisX: {
        //             offset: 30
        //         },
        //         axisY: {
        //             offset: 100,
        //         }
        //     }
    }

    /**
     * Template Paie Graph options
     *
     * @return string
     */
    private static function templatePieGraphOptions($key) : string
    {
        return "{labelInterpolationFnc:function(value){return value},axisX:{offset:30},axisY:{offset:100,},plugins:[Chartist.plugins.legend()],chartPadding:15,labelOffset:50,labelDirection:'explode',labelInterpolationFnc:function(value){var series=data_{$key}.series.map(a=>a.value).map(Number);var labels = data_{$key}.labels;var position = labels.indexOf(value);var total=series.map(Number).reduce((partial_sum,a)=>partial_sum+a);var currentValue=series[position];var percent = Math.round(currentValue/total*100);return currentValue ? value + ' ('+percent+'%)' : value;}},";
        //     {
        //         labelInterpolationFnc: function(value) {
        //             return value
        //         },
        //         axisX: {
        //             offset: 30
        //         },
        //         axisY: {
        //             offset: 100,
        //         },
        //         plugins: [
        //             Chartist.plugins.legend()
        //         ],
        //         chartPadding: 15,
        //         labelOffset: 50,
        //         labelDirection: 'explode',
        //         labelInterpolationFnc: function(value) {
        //             var series = data_{$key}.series.map(a => a.value).map(Number);
        //             var labels = data_{$key}.labels;
        //             var position = labels.indexOf(value);
        //             var total = series.map(Number).reduce((partial_sum, a) => partial_sum + a);
        //             var currentValue = series[position];
        //             var percent = Math.round(currentValue / total * 100);
        //             return currentValue ? value + ' (' + percent + '%)' : value;
        //         },
        //     }
    }
}
