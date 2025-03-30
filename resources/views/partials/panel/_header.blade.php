<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ $title }} &mdash; SIAPP</title>
    <link rel="shortcut icon" href="{{ asset('assets') }}/logo.png" type="icon">
    <link href="{{ asset('assets') }}/dist/css/tabler.min.css?1684106062" rel="stylesheet"/>
    <link href="{{ asset('assets') }}/dist/css/tabler-flags.min.css?1684106062" rel="stylesheet"/>
    <link href="{{ asset('assets') }}/dist/css/tabler-payments.min.css?1684106062" rel="stylesheet"/>
    <link href="{{ asset('assets') }}/dist/css/tabler-vendors.min.css?1684106062" rel="stylesheet"/>
    <link href="{{ asset('assets') }}/dist/css/demo.min.css?1684106062" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@1.0.4/dist/simple-notify.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">
    @stack('styles')
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body >
    <script src="{{ asset('assets') }}/dist/js/demo-theme.min.js?1684106062"></script>
