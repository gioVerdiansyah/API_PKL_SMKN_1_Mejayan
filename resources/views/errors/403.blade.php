@extends('errors::minimal')

@section('title', 'Forbidden')
@section('code', '403')
@section('err_description', __($exception->getMessage() ?: 'Access Denied. You Do Not Have The Permission To Access This Page On This Server'))
@section('err_caused', "execute access forbidden, read access forbidden, write access forbidden, ssl required, ssl 128 required, ip address rejected, client certificate required, site access denied, too many users, invalid configuration, password change, mapper denied access, client certificate revoked, directory listing denied, client access licenses exceeded, client certificate is untrusted or invalid, client certificate has expired or is not yet valid, passport logon failed, source access denied, infinite depth is denied, too many requests from the same client ip")
