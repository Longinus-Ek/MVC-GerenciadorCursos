<?php 

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Trait\FlashMessageTrait;
use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Controller\InterfaceControladorRequisicao;

class Persistencia implements InterfaceControladorRequisicao
{
    use FlashMessageTrait;

    private $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
    }
    public function processaRequisicao(): void
    {
        $descricao = htmlspecialchars($_POST['descricao'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', true);

        $curso = new Curso();
        $curso->setDescricao($descricao);

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $tipo = 'success';
        if(!is_null($id) && $id !== false){
            $curso->setId($id);
            $this->entityManager->merge($curso);
            $this->defineMensagem($tipo, 'Curso atualizado com sucesso');
        } else {
            $this->entityManager->persist($curso);
            $this->defineMensagem($tipo, 'Curso inserido com sucesso');
        }
        $this->entityManager->flush();

        header('Location: /listar-cursos', true, 302);
    }
}