@extends('errors::minimal')

@section('title', 'Service Unavailable')
@section('code', '503')
@section('err_description'," Service Unavailable. The server is currently unable to handle the request due to temporary overload or maintenance.")
@section('err_caused', "Server maintenance: The server is temporarily taken offline for maintenance or updates.
Temporary overload: The server is experiencing a high volume of requests or excessive load.
Service disruption: The requested service or functionality is temporarily unavailable or experiencing issues.")
