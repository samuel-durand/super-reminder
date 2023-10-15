<?php
session_start();
require_once('Class/User.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenez le contenu JSON de la requête
    $content = trim(file_get_contents("php://input"));
    $data = json_decode($content, true);

    $login = trim(htmlspecialchars($data['login']));
    $firstname = trim(htmlspecialchars($data['firstname']));
    $lastname = trim(htmlspecialchars($data['lastname']));
    $password = trim(htmlspecialchars($data['password']));

    // Vérifiez d'abord si l'utilisateur existe déjà
    $existingUser = $userCrud->loginUser($login, $password);

    if ($existingUser) {
        // L'utilisateur existe déjà, retournez une réponse JSON
        $response = array('success' => false, 'message' => 'Cet utilisateur existe déjà.');
        echo json_encode($response);
    } else {
        // L'utilisateur n'existe pas, essayez de créer un nouvel utilisateur
        $user = $userCrud->createUser($login, $firstname, $lastname, $password, 0);

        if ($user) {
            // L'inscription a réussi, retournez une réponse JSON
            $response = array('success' => true, 'user' => $user);
            echo json_encode($response);
        } else {
            // Une erreur s'est produite lors de l'inscription, retournez une réponse JSON
            $response = array('success' => false, 'message' => 'Une erreur s\'est produite lors de l\'inscription.');
            echo json_encode($response);
        }
    }
}
?>
