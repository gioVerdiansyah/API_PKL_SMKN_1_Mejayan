@extends('errors::minimal')

@section('title', 'Unauthorized')
@section('code', '401')
@section('err_description', "Unauthorized. Access is denied due to invalid credentials or lack of authentication.")
@section('err_caused', "Invalid credentials: The provided username or password is incorrect.Missing authentication token: The request requires an authentication token, but it is missing or not provided.Expired authentication token: The authentication token has expired, and a new token is required.Insufficient privileges: The authenticated user does not have the necessary permissions to access the requested resource.Revoked access: The access to the resource has been revoked for the authenticated user.Inactive user account: The user account associated with the authentication credentials is inactive or disabled.Incorrect authentication method: The authentication method used is not supported or recognized by the server.Expired session: The user's session has expired, and they need to reauthenticate. IP address restriction: The request is coming from an IP address that is not allowed to access the resource.")
