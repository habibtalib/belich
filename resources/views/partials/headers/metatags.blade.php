{{-- Title --}}
<title>{{ config('belich.name') }}</title>

{{-- Metatags --}}
<meta charset="utf-8">
<meta name="keywords" content=""/>
<meta name="description" content=""/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="index, follow">
<meta name="copyright"content="Damián Aguilar">
<meta name="language" content="{{ app()->getLocale() }}">
<meta name="revised" content="Sunday, July 18th, 2010, 5:15 pm" />
<meta name="url" content="{{ config('belich.url') }}">
<meta name="identifier-URL" content="{{ config('belich.url') }}">
<meta name="directory" content="submission">
<meta name="category" content="">
<meta name="coverage" content="Worldwide">
<meta name="distribution" content="Global">
<meta name="rating" content="General">
<meta name="revisit-after" content="7 days">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">

{{-- Custom metatags --}}
<meta name="google-analytics" content=""/>
<meta name="disqus" content=""/>

{{-- Apple metatags --}}
<meta name="apple-mobile-web-app-capable" content="yes">
<meta content="yes" name="apple-touch-fullscreen" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
