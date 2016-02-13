<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
//require __DIR__ . '/../src/routes.php';

// Include Config files
require __DIR__ . '/../config/config.php';

// Include DB class files
require __DIR__ . '/../data/dataapp.php';

// Define app routes
$app->get('/users', function ($request, $response, $args) {
	$dbApp = new dataapp();
	$user_data = $dbApp->getUsers();
	echo json_encode($user_data);
});

$app->get('/users/{id}', function ($request, $response, $args) {
    $dbApp = new dataapp();
	$user_data = $dbApp->getUserDetails($args['id']);
	echo json_encode($user_data);
});

$app->post('/users', function ($request, $response, $args) {
	$parsedBody = $request->getParsedBody();
	//$parsedBody = json_decode(file_get_contents("php://input"),true);
	//var_dump($parsedBody);
	$register_data = array(
		'name' => $parsedBody["name"],
		'email' => $parsedBody["email"],
		'phone' => $parsedBody["phone"]
	);
	
	$dbApp = new dataapp();
	$result = $dbApp->registerUser($register_data);
	echo json_encode($result);
});

$app->put('/users/{id}', function ($request, $response, $args) {
	$parsedBody = $request->getParsedBody();
	//var_dump($parsedBody);
	$user_data = array(
		'name' => $parsedBody["name"],
		'email' => $parsedBody["email"],
		'phone' => $parsedBody["phone"]
	);
	
	$dbApp = new dataapp();
	$result = $dbApp->updateUserDetails($args['id'], $user_data);
	echo json_encode($result);
	
});

$app->delete('/users/{id}', function ($request, $response, $args) {
    $dbApp = new dataapp();
	$result = $dbApp->deleteUser($args['id']);
	echo json_encode($result);
});

// Run app
$app->run();
