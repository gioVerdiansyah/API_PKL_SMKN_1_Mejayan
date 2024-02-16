@extends('errors::minimal')

@section('title', 'Not Found')
@section('code', '404')
@section('err_description', "Not Found. The requested resource could not be found on the server.")
@section('err_caused', "Incorrect URL: The URL provided in the request does not correspond to a valid resource.
Deleted or moved resource: The requested resource has been deleted or moved to a different location.
Broken links: The links within the application or website are pointing to non-existent or broken resources.")
