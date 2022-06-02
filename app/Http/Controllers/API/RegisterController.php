<?php

/**
  * @package App\
 * @subpackage Http\Controllers\API
 * @author Mamy
 */
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

/**
 * Cette classe permet de faire les differentes type de requête entre la base de données et le frontend
  * @package App\
 * @subpackage Http\Controllers\API
 */
class RegisterController extends BaseController
{
    /**
     * Enregistrement d'un utilisateur dans la base de données
     *
     * @return \Illuminate\Http\Response $tssuccess retourne une message d'authentification
     */
    public function register(Request $_srequest)
    {
        $validator = Validator::make($_srequest->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails())
        {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $_srequest->all();
        $input['name'] = "defaultName";
        $input['password'] = bcrypt($input['password']);

        $ouser = User::create($input);
        $tssuccess['token'] =  $ouser->createToken('MyApp')->accessToken;
        $tssuccess['name'] =  $ouser->name;
        $tssuccess['email'] =  $ouser->email;

        return $this->sendResponse($tssuccess, 'User register successfully.');
    }

    /**
     * Authentification d'un utilisateur
     *
     * @return \Illuminate\Http\Response $tssuccess retourne une message d'authentification
     */
    public function login(Request $_srequest)
    {
        if (Auth::attempt(['email' => $_srequest->email, 'password' => $_srequest->password]))
        {
            $ouser = Auth::user();
            $tssuccess['token'] =  $ouser->createToken('MyApp')->accessToken;
            $tssuccess['name'] =  $ouser->name;
            $tssuccess['email'] =  $ouser->email;

            return $this->sendResponse($tssuccess, 'User login successfully.');
        }
        else
        {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
