<?php

// Incluir a conexao com o banco de dados
include_once "conexao.php";

// Receber os dados do formulário via método POST
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

// Verificar se o ID não está vazio
if (!empty($id)) {
    // Preparar a query para deletar o usuário com o ID fornecido
    $query_usuario = "DELETE FROM usuarios WHERE id=:id";
    $del_usuario = $conn->prepare($query_usuario);
    $del_usuario->bindParam(':id', $id);

    // Executar a query para deletar o usuário
    if ($del_usuario->execute()) {
        
        // Se o uuário for deletado com sucesso, preparar a query para deletar o endereço associado a esse usuário 
        $query_endereco = "DELETE FROM usuarios WHERE id=:id";
        $del_endereco = $conn->prepare($query_endereco);
        $del_endereco->bindParam(':usuario_id', $id);

        // Executar a query para deletar o endereço associado usuário
        if ($del_usuario->execute()) {
            // Se ambos, usuário e endereço, forem deletados com sucesso, retornar uma mensagem de sucesso 
            $retorna = ['status' => true, 'msg' => "<div class='alert alert-success' role='alert'>Erro: Usuário apagado com sucesso!</div>"];
        } else {
            // Se o usuário for deletado com sucesso, mas o endereço não, retorna uma mensagem de sucesso 
            $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário apagado, endereço não apagado com sucesso!</div>"];
        }
        } else {
            //Se houver um erro ao deletar o usuário, retornar uma menagem de erro 
            $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Usuário apagado, endereço não apagado com sucesso!</div>"];
        }

    } else {
        // Se o ID estiver vazio, retorna uma mensagem de erro
        $retorna = ['status' => false, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Nenhum usuário encontrado!</div>"];
}
    
// Retorna o resultado em formato JSON
echo json_encode($retorna);