@extends('errors::minimal')

@section('title', 'Server Error')
@section('code', '500')
@section('err_descriprion', __($exception->getMessage() ?: 'Internal Server Error. An unexpected error occurred on the server.'))
@section('err_caused', "Server misconfiguration: The server's configuration settings are incorrect or incompatible.
Database connection failure: The server is unable to establish a connection to the required database.
Runtime error: An unexpected error occurred during the execution of server-side code.")
