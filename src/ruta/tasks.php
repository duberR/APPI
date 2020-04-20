<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// GET Todos los clientes

$app->get('/api/tasks', function(Request $request, Response $response){
    //$id_cliente = $request->getAttribute('id');
    //echo "Todos los clientes";

    $sql = "SELECT * FROM tasks";
    try{
        $db = new db();
        $db = $db->conecctiondb();
        $resultado = $db->query($sql);
        if($resultado->rowCount() > 0){
            $tasks = $resultado->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($tasks);
        }else{
            echo json_decode("no existen tasks en  la base de datos");
        }
        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

// POST para crear un nuevo cliente

$app->post('/api/tasks/new', function(Request $request, Response $response){
    //echo "Todos los clientes";
    $tasks = $request->getParam('tasks');
    $dates = $request->getParam('dates');


    $sql = "INSERT INTO tasks (tasks,dates) VALUES
            (:tasks, :dates)";
    try{
        $db = new db();
        $db = $db->conecctiondb();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':tasks', $tasks);
        $resultado->bindParam(':dates', $dates);

        $resultado->execute();

        echo json_encode("task guardado");

        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});

// PUT Modificar cl

$app->put('/api/tasks/modify/{id}', function(Request $request, Response $response){
    $id_task= $request->getAttribute('id');

    $tasks = $request->getParam('tasks');
    $dates = $request->getParam('dates');
    $sql = "UPDATE tasks SET
           tasks = :tasks,
           dates= :dates

            WHERE  id = $id_task";

    try{
        $db = new db();
        $db = $db->conecctiondb();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':tasks', $tasks);
        $resultado->bindParam(':dates', $dates);

        $resultado->execute();

        echo json_encode("task modify");


        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});
// DELETE para ELIMINAR UN CLIENTE

$app->delete('/api/clientes/delete/{id}', function(Request $request, Response $response){
    $id_tasks = $request->getAttribute('id');
    $sql = "DELETE FROM tasks WHERE  id = $id_tasks";

    try{
        $db = new db();
        $db = $db->conecctiondb();
        $resultado = $db->prepare($sql);
        $resultado->execute();

        if($resultado->rowCount() > 0){
            echo json_encode("task Eliminado");
        }else{
            echo json_encode("No existe cliente con este id");
        }

        $resultado = null;
        $db = null;
    }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
    }
});