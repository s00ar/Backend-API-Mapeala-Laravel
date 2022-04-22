<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\ContactMailable;
use Illuminate\Support\Facades\Mail;
use Validator;

class ContactController extends Controller
{
    //Se genera el listado de todos los contactos
    public function index()
    {
    //acá devuelve la vista
        $contacts = Contact::all();
        return $contacts;
    }
    //nuestra función de almacenaje
    public function store(Request $request)
    {
    //todas nuestras validaciones
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:60',
            'email' => 'required|email', 
            'phone' => 'required|integer|numeric', 
            'message' => 'required'
        ]);
    //y en caso de que la validacion falle
        if ($validator->fails()) { 
		return response()->json(['error'=>$validator->errors()], 401);            
		}
        //Guardar el contacto
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->message = $request->message;
        $contact->save();
        //enviar el email
        \Mail::send('contactMail', array( 
            'name' => $contact['name'], 
            'email' => $contact['email'], 
            'phone' => $contact['phone'], 
            'mensaje' => $contact['message'], 
        ), function($respuesta) use ($request){ 
            $respuesta->from($request->email); 
            $respuesta->to('leston.s.h@gmail.com', 'Admin')->subject($request->get('name'));
        }); 
        //nos retornael contacto
        return response()->json(['Éxito' => 'Formulario registrado y enviado correctamente']);
    }

    public function show($id)
    {
        //indexa un contacto
        $contact = Contact::find($id);

        return $contact;
    }

    public function update(Request $request, $id)
    {
        //ocupa la función de actualizar un contacto
        $contact = Contact::findOrFail($request->id);
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->message = $request->message;
        $contact->save();
    //Devuelve el contacto
        return $contact;
    }

    public function destroy($id)
    {
    //Elimina un contacto
        $contact = Contact::destroy($id);
    //Muestra el contacto eliminado
        return $contact;
    }
}
