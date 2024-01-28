<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMeRequest;
use App\Mail\ContactMeMail;
use Illuminate\Support\Facades\Mail;

class ContactMeController extends Controller
{
    public function contactMe(ContactMeRequest $request){
        try{
            Mail::to(config('app.dev_email'))->send(new ContactMeMail($request->all()));
            return response()->json(['success' => true, 'message' => "Berhasil mengirim pesan!"], 200);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => "Ada kesalahan server saat mengirim pesan, cobalah lagi...", 'error' => $e], 200);
        }
    }
}
