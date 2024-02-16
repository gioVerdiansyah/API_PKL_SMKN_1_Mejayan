@extends('errors::minimal')

@section('title', __('Payment Required'))
@section('code', '402')
@section('err_description',"Payment Required. The server requires payment or valid payment credentials to fulfill the request.")
@section('err_caused', "Payment processing failure: The payment transaction failed or encountered an error.
Expired payment method: The payment method provided has expired or is no longer valid.")
