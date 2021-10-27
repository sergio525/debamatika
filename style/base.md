# 'base_html.twig' <head> content
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>{% block title %}Welcome!{% endblock %}</title>
    {% block stylesheets %}
          <link href="{{ asset('css/grid.css') }}" rel="stylesheet" /> 
          <link href="{{ asset('template/css/classic.css') }}" rel="stylesheet">
          <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
                crossorigin="anonymous">
          <link href="{{ asset('js/jquery/jquery-ui.css') }}" rel="stylesheet" />  
          <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    {% endblock %}

    {% block javascripts %}
          {{ encore_entry_script_tags('app') }}
          <script src="{{ asset('js/jquery/jquery-ui.js') }}" type="text/javascript"></script>
          <script src="{{ asset('js/jquery/jquery-ui.min.js') }}" type="text/javascript"></script>
    {% endblock %}
