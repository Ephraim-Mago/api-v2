<?php
    // Se connecter à la base de données
    include("../db.php");
    $request_method = $_SERVER["REQUEST_METHOD"];
    
    switch($request_method)
    {
        case 'GET':
            if(!empty($_GET["slug"]))
            {
                // Récupérer un seul produit
                $slug = ($_GET["slug"]);
                getProduct("slug", $slug);
            }
            else
            {
                // Récupérer tous les produits
                getProducts();
            }
        break;

        case 'POST':
            // Ajouter un produit
            AddProduct();
        break;

        case 'PUT':
            // Modifier un produit
            $id = ($_GET["slug"]);
            updateProduct($id);
        break;

        case 'DELETE':
            // Supprimer un produit
            $slug = ($_GET["slug"]);
            deleteProduct("slug", $slug);
        break;

        default:
            // Requête invalide
            header("HTTP/1.0 405 Method Not Allowed");
        break;
    }

    function getProducts(string $table = "products")
    {
        global $conn;
        $response = array();
        
        $query = "SELECT * FROM {$table} ORDER BY created_at DESC";
        $result = $conn->query($query);
        $response = $result->fetchAll();
        
        header('Content-Type: application/json');
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
    
    function getProduct(string $key, string $value, string $table = "products")
    {
        global $conn;
        $response = array();
        
        $query = "SELECT * FROM {$table} WHERE {$key} = ?";
        $result = $conn->prepare($query);
        $result->execute([$value]);
        $response = $result->fetch();
        
        header('Content-Type: application/json');
        echo json_encode($response, JSON_PRETTY_PRINT);
    }

    function AddProduct(string $table = "products")
    {
        global $conn;
        $name = $_POST["name"];
        $slug = $_POST["slug"];
        $description = $_POST["description"];
        $price = $_POST["price"];

        $query = "INSERT INTO {$table}(name, slug, description, price) VALUES(?,?,?,?)";
        $result = $conn->prepare($query);
        $result->execute([$name, $slug, $description, $price]);

        if($result)
        {
            $response=array(
                'status' => 1,
                'status_message' =>'Produit ajoute avec succes.'
            );
        } else 
        {
            $response=array(
                'status' => 0,
                'status_message' =>'ERREUR!.'. $result->getMessage
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function updateProduct(string $value, string $table = "products")
    {
        global $conn;
        $_PUT = array(); //tableau qui va contenir les données reçues
        parse_str(file_get_contents('php://input'), $_PUT);
        $name = $_PUT["name"];
        $slug = $_PUT["slug"];
        $description = $_PUT["description"];
        $price = $_PUT["price"];
        $update_at = date('Y-m-d H:i:s');

        $query = "UPDATE {$table} SET name = :name, slug = :slug, description = :description, price = :price, updated_at = :updated_at WHERE id = :id";
        $result = $conn->prepare($query);
        $result->execute(['name' => $name, 'slug' => $slug, 'description' => $description, 'price' => $price, 'updated_at' => $update_at, 'id' => $value]);

        if($result)
        {
            $response=array(
                'status' => 1,
                'status_message' =>'Produit modifier avec succes.'
            );
        } else 
        {
            $response=array(
                'status' => 0,
                'status_message' =>'ERREUR!.'. $result->getMessage
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function deleteProduct(string $key, string $value, string $table = "products")
    {
        global $conn;
        $response = array();
        
        $query = "DELETE FROM {$table} WHERE {$key} = ?";
        $result = $conn->prepare($query);
        $result->execute([$value]);

        if($result)
        {
            $response=array(
                'status' => 1,
                'status_message' =>'Produit supprimer avec succes.'
            );
        } else 
        {
            $response=array(
                'status' => 0,
                'status_message' =>'ERREUR!.'. $result->getMessage
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

?>