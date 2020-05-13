 <?php

$router->get('', 'MainController@index');

$router->get('logout', 'AuthController@logout');
$router->get('login', 'AuthController@login');
$router->get('login/restore', 'AuthController@restoreLogin');

$router->get('register', 'AuthController@register');

$router->get('personalArea', 'AccountController@personalArea');

// language controller
$router->get('lang', 'AccountController@lang');
$router->post('lang', 'AccountController@lang');

 // Search controller
$router->get('search', 'AccountController@search');
$router->post('search', 'AccountController@search');

 // 42 login controller
$router->get('callback&response_type=code', 'AccountController@callback');
$router->post('callback&response_type=code', 'AccountController@callback');

 // GitHUB login controller
$router->get('gitcallback', 'AccountController@gitcallback');
$router->post('gitcallback', 'AccountController@gitcallback');

$router->get('register/verification', 'AuthController@verification');
$router->get('personalArea/edit', 'AuthController@editAccaunt');
$router->get('personalArea/edit/email', 'AuthController@editEmail');
$router->get('personalArea/delete', 'UserController@deleteAccaunt');
$router->get('personalArea/delimg', 'AccountController@dellUserImage');
$router->get('personalArea/notifications', 'AccountController@notifications');
$router->get('datingMovie', 'DatingController@dating');
$router->get('profile', 'UserController@userProfile');
$router->get('searchUser', 'DatingController@searchUser');
$router->get('pageMovie', 'AccountController@moviePage');
$router->get('acauntLike/add', 'AccountController@acauntLikeAdd');
$router->get('acauntLike/del', 'AccountController@acauntLikeDel');
$router->get('sendMassage', 'MassegeController@sendMassage');
$router->get('reloadMassage', 'MassegeController@reloadMassage');
$router->get('checkNewMassege', 'MassegeController@checkNewMassege');

$router->get('pageMovie/movieComment', 'AccountController@addComment');
$router->post('pageMovie/movieComment', 'AccountController@addComment');

$router->get('pageMovie/viewedMovie', 'AccountController@viewedMovie');
$router->post('pageMovie/viewedMovie', 'AccountController@viewedMovie');

$router->post('userbanadd', 'UserController@userBanAdd');
$router->post('userbandell', 'UserController@userBanDell');

$router->post('login', 'AuthController@login');
$router->post('login/restore', 'AuthController@restoreLogin');

$router->post('register', 'AuthController@register');
$router->post('personalArea/delete', 'UserController@deleteAccaunt');
$router->post('personalArea', 'AccountController@personalArea');
$router->post('personalArea/edit', 'AuthController@editAccaunt');
$router->post('personalArea/edit/email', 'AuthController@editEmail');
$router->post('personalArea/delimg', 'AccountController@dellUserImage');
$router->post('personalArea/notifications', 'AccountController@notifications');

$router->post('profile', 'UserController@userProfile');
$router->post('geolocation', 'UserController@usergeolocation');
$router->post('searchUser', 'DatingController@searchUser');
$router->post('pageMovie', 'AccountController@moviePage');

$router->post('movieLike/add', 'AccountController@likeAdd');
$router->post('movieLike/del', 'AccountController@likeDel');

$router->post('sendMassage', 'MassegeController@sendMassage');
$router->post('reloadMassage', 'MassegeController@reloadMassage');
$router->post('statusMassage', 'MassegeController@statusMassage');
$router->post('checkNewMassege', 'MassegeController@checkNewMassege');
$router->post('newMassegeChat', 'MassegeController@newMassegeChat');

$router->get('page-not-found', 'MainController@page404');
