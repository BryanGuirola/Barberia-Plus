<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static function soloEncargados()
    {
        return self::where('rol', 'encargado')->get();
    }
    public function citasCliente()
    {
        return $this->hasMany(Cita::class, 'cliente_id');
    }

    public function citasEncargado()
    {
        return $this->hasMany(Cita::class, 'encargado_id');
    }
    public function horarios()
{
    return $this->hasMany(Horario::class, 'encargado_id');
}


    public static function validacion($editar = false, $id = null)
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', $editar ? "unique:users,email,$id" : 'unique:users,email'],
            'password' => $editar ? 'nullable|string|min:6' : 'required|string|min:6',
            'rol' => 'required|in:administrador,encargado',
        ];
    }

    /**
     * Crea un nuevo usuario con contraseña encriptada.
     */
    public static function crearUsuario($data)
    {
        $data['password'] = Hash::make($data['password']);
        return self::create($data);
    }

    /**
     * Actualiza el usuario actual. Si la contraseña es vacía, no se cambia.
     */
    public function actualizarUsuario($data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $this->update($data);
    }

    /**
     * Elimina este usuario.
     */
    public function eliminarUsuario()
    {
        return $this->delete();
    }

    /**
     * Devuelve todos los usuarios con rol administrador.
     */
    public static function soloAdministradores()
    {
        return self::where('rol', 'administrador')->get();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'must_change_password', 
    ];



    // Busca clientes por nombre o email (para autocompletar)
    public static function buscarClientes($query)
    {
        return self::where('rol', 'cliente')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                    ->orWhere('email', 'like', "%$query%");
            })
            ->select('id', 'name', 'email')
            ->limit(10)
            ->get();
    }

    // Registra nuevo cliente rápidamente
    public static function crearClienteRapido(array $data)
    {
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'] ?? 'cliente123'), // valor por defecto si no se pasa
            'rol' => 'cliente',
            'must_change_password' => true , // ✅ obligatorio al crear
        ]);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function todos()
    {
        return self::all();
    }
}
