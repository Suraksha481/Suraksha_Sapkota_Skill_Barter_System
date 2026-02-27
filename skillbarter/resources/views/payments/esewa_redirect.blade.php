@extends('app')

@section('content')
<div class="container">
    <h2>Redirecting to eSewa...</h2>
    <p>Please wait while we take you to eSewa to complete payment.</p>
    <form id="esewa_form" action="https://esewa.com.np/epay/main" method="POST">
        <input type="hidden" name="tAmt" value="{{ $esewa['tAmt'] }}">
        <input type="hidden" name="amt" value="{{ $esewa['amt'] }}">
        <input type="hidden" name="psc" value="{{ $esewa['psc'] }}">
        <input type="hidden" name="pdc" value="{{ $esewa['pdc'] }}">
        <input type="hidden" name="scd" value="{{ $esewa['scd'] }}">
        <input type="hidden" name="pid" value="{{ $esewa['pid'] }}">
        <input type="hidden" name="su" value="{{ $esewa['success_url'] }}">
        <input type="hidden" name="fu" value="{{ $esewa['failure_url'] }}">
    </form>
</div>

<script>document.getElementById('esewa_form').submit();</script>
@endsection
