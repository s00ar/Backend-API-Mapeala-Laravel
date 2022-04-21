<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

use App\Mail\ContactMailable;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();
        return $contacts;

        // return view('contactanos.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([ 
            'name' => 'required', 
            'email' => 'required|email', 
            'phone' => 'required', 
            'message' => 'required', 
        ]); 

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->message = $request->message;

        $contact->save();

        // $correo = new ContactMailable($request->all());
   
        // Mail::to('c_fad@hotmail.com')->send($correo);

        // return "Mensaje Enviado";



        /* //  Send mail to admin 
        \Mail::send('contactMail', array( 
            'name' => $contact['name'], 
            'email' => $contact['email'], 
            'phone' => $contact['phone'], 
            'message' => $contact['message'], 
        ), function($message) use ($request){ 
            $message->from($request->email); 
            $message->to('leston.s.h@gmail.com', 'Admin')->subject($request->get('subject')); 
        }); 

        return redirect()->back()->with(['success' => 'Formulario enviado correctamente']); */ 
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = Contact::find($id);

        return $contact;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($request->id);
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->message = $request->message;

        $contact->save();

        return $contact;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contact = Contact::destroy($id);

        return $contact;
    }
}
