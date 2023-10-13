<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return $usuarios;
    }

    public function show($id)
    {
        $usuario = Usuario::find($id);
    
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    
        return response()->json($usuario);
    }
    
    
    

    public function store(Request $request)
    {
        // Valida los datos entrantes
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required', // Asegúrate de que estés validando el campo "apellido"
            'email' => 'required|email|unique:usuarios', // Valida que el correo sea único
        ]);
    
        // Crea un nuevo usuario utilizando los datos de la solicitud
        $usuario = new Usuario;
        $usuario->nombre = $request->input('nombre');
        $usuario->apellido = $request->input('apellido'); // Asegúrate de asignar el apellido
        $usuario->email = $request->input('email');
    
        // Guarda el usuario en la base de datos
        $usuario->save();
    
        // Devuelve una respuesta de éxito
        return response()->json(['message' => 'Usuario creado con éxito'], 201);
    }
    

    public function update(Request $request, $id)
    {
        // Valida los datos entrantes
        $request->validate([
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            // Puedes agregar más reglas de validación según tus necesidades
        ]);
    
        // Encuentra el usuario existente por ID
        $usuario = Usuario::find($id);
    
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    
        // Actualiza los campos del usuario en función de los datos de la solicitud
        $usuario->nombre = $request->input('nombre');
        $usuario->apellido = $request->input('apellido');
        $usuario->email = $request->input('email');
        // Actualiza otros campos según sea necesario
    
        // Guarda los cambios en la base de datos
        $usuario->save();
    
        // Devuelve una respuesta de éxito
        return response()->json(['message' => 'Usuario actualizado con éxito'], 200);
    }
    
    

    public function destroy($id)
    {
        $usuario = Usuario::find($id);
    
        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    
        // Utiliza el método destroy para eliminar el usuario por su ID
        Usuario::destroy($id);
    
        return response()->json(['message' => 'Usuario eliminado con éxito'], 200);
    }
    
}
