@extends('errors::minimal')

@section('title', 'Too Many Requests')
@section('code', '429')
@section('err_description', "Too Many Requests. The user has exceeded the allowed number of requests in a given time period.")
@section('err_caused', "Rate limiting: The server has imposed restrictions on the number of requests a user or client can make within a specific timeframe.
Traffic congestion: The server is experiencing a high volume of requests, impacting its ability to handle additional requests.")
