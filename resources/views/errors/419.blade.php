@extends('errors::minimal')

@section('title', 'Page Expired')
@section('code', '419')
@section('err_description', "Authentication Timeout. The session has expired. Please refresh the page and log in again.")
@section('err_caused', "Inactivity timeout: The user's session is automatically terminated after a period of inactivity.
Session expiration: The session duration has exceeded its predefined expiration time.
Expired CSRF token: The CSRF (Cross-Site Request Forgery) token used for security validation has expired.")
