<?php

namespace App\Validation;

use App\Database;
use App\Repositories\UserRepository;
use Exception;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthUser
{
  protected $secret_key;

  protected $userRepository;
  
  public function __construct($secret_key)
  {
    $this->secret_key = $secret_key;
    
    $database = new Database;
      
    $this->userRepository = new UserRepository($database);
  }
  
  public function createToken($userData) :string
  {
    $payload = [
      'id' => $userData['id_user'],
      'login' => $userData['login'],
      'senha' => $userData['senha'],
      'tipo' => $userData['tipo']
    ];
    
    $jwt = JWT::encode($payload, $this->secret_key , 'HS256');//args->informacoes, chave secreta, criptografia
    
    return $jwt;
  }

  public function authToken($token) : bool
  {
    if ($token) {
      // Verifica se a string começa com "Bearer "
      if (strpos($token, 'Bearer ') === 0) {
          // Remove o prefixo "Bearer " da string
          $token = substr($token, 7);
      }
      try {
        $decoded = JWT::decode($token, new Key($this->secret_key, 'HS256'));
        
        $userCpfToken = $decoded->cpf;
        $data = $this->userRepository->getAuth($userCpfToken);
        $userCpfFromDb = $data[0]->cpf;
        

        if($userCpfToken == $userCpfFromDb ){
          return true;
        }
       } catch (Exception $e) {
         print_r($e->getMessage());
         return false;
       }
    }
    print_r("token inexistente");
    return false;
    
  }
}