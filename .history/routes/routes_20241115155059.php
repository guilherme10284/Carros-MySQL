<?php
use src\Route as Route;
use classes\authentication\Authentication;

//Zona sem autenticação
Route::get('/', function(){require _CAMINHO_TEMPLATE. "index.html";});
Route::get('/batatas', function(){require _CAMINHO_TEMPLATE. "index.html";});
Route::get('/admin/json', function(){require _CAMINHO_TEMPLATE. "tabelaCarros.html";});
Route::get('/admin/carros', function(){require _CAMINHO_TEMPLATE. "tabelaCarros.html";});
Route::get('/erros/401', function(){require _CAMINHO_ERROS. "erro401.php";});
Route::get('/erros/404', function(){require _CAMINHO_ERROS. "erro404.php";});

//Carros
Route::get(['set' => '/api/carros', 'as' => 'carros.getAll'], 'ControllerCarros@getAll');
Route::get(['set' => '/api/carros/{id}', 'as' => 'carros.getById'], 'ControllerCarros@getById');
Route::post(['set' => '/api/carros/create', 'as' => 'carros.create'], 'ControllerCarros@create');
Route::put(['set' => '/api/carros/update', 'as' => 'carros.update'], 'ControllerCarros@update');
Route::delete(['set' => '/api/carros/delete/{id}', 'as' => 'carros.delete'], 'ControllerCarros@delete');

Route::get(['set' => '/base/index', 'as' => 'base.index'], 'Controller@index'); 
Route::get(['set' => '/base/show/{id}', 'as' => 'base.show'], 'Controller@show'); 

//Artigos
Route::get(['set' => '/artigos/numeros', 'as' => 'artigos.contarArtigos'], 'ControllerArtigos@contarArtigos');
Route::get(['set' => '/artigo/{id}/ver', 'as' => 'artigos.ArtigoVer'], 'ControllerArtigos@ArtigoVer');                      //web service
Route::get('/artigo/ver/{id}', function(){  require _CAMINHO_TEMPLATE1. "artigo.php";});          //ver artigo
Route::get('/artigo/ver/', function(){  require _CAMINHO_TEMPLATE1. "artigo.php";});          //ver artigo

//Users
Route::get(['set' => '/users/contar', 'as' => 'users.contarUsers'], 'ControllerUser@contarUsers'); 
Route::get(['set' => '/users/lista', 'as' => 'users.listOfUsers'], 'ControllerUser@listOfUsers');

//Autenticação
$aut=new Authentication();
if ($aut->isLoged()){
  //Zona com autenticação
  //Users
  Route::get('/users', function(){  require _CAMINHO_ADMIN. "utilizadoresGere.php";});          //mostra todos os users
  Route::post('/users', function(){  require _CAMINHO_ADMIN. "utilizadoresGere.php";}); 
  
  //Artigos
  Route::get('/artigos', function(){  require _CAMINHO_ADMIN. "artigosGerir.php";});                //mostra os últimos artigos
  Route::post('/artigos', function(){  require _CAMINHO_ADMIN. "artigosGerir.php";});
  Route::post(['set' => '/artigo/add', 'as' => 'artigos.addArtigo'], 'ControllerArtigos@addArtigo'); 
  Route::get(['set' => '/artigo/add', 'as' => 'artigos.addArtigo'], 'ControllerArtigos@addArtigo'); 
}else{
  //echo "Não tem acesso";
  //header('Location: https://www.esmonserrate.org/public/semAcesso');
  //exit;
  Route::get('/{any}', function(){  require _CAMINHO_ERROS. "erro401.php";});
  Route::get('/{any}/{any}', function(){  require _CAMINHO_ERROS. "erro401.php";});
  Route::get('/{any}/{any}/{any}', function(){  require _CAMINHO_ERROS. "erro401.php";});
}

Route::get('/{any}', function(){  require _CAMINHO_ERROS. "erro404.php";});
Route::get('/{any}/{any}', function(){  require _CAMINHO_ERROS. "erro404.php";});
Route::get('/{any}/{any}/{any}', function(){  require _CAMINHO_ERROS. "erro404.php";});

?>
