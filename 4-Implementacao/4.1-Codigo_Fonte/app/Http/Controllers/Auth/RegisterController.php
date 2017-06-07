<?php

namespace App\Http\Controllers\Auth;

use App\Entities\Enumeration\TipoUsuario;
use App\Entities\Usuario;
use App\User;
use App\Http\Controllers\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Entity Manager instance
     *
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $em;

    /**
     * Create a new controller instance.
     *
     * @param \Doctrine\ORM\EntityManagerInterface
     * @return void
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'login' => 'required|max:255|unique:App\Entities\Usuario',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Entities\Usuario
     */
    protected function create(array $data)
    {
        $user = new Usuario($data['name'], $data['login']);
        $user->setPassword(bcrypt($data['password']));
        $user->setTipo(TipoUsuario::$ADMINISTRADOR);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }
}
