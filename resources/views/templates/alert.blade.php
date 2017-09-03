@if(Session::has('info'))
<div class="alert alert-info" role="alert" id="success-alert" style="text-align: center;">{{ Session::get('info') }}</div>
@endif