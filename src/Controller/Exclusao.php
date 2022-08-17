<?php 

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Trait\FlashMessageTrait;
use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Controller\InterfaceControladorRequisicao;

class Exclusao implements InterfaceControladorRequisicao
{
    use FlashMessageTrait;

    /** @var \Doctrine\ORM\EntityManagerInterface */

    private $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())
            ->getEntityManager();
    }
    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


        if(is_null($id) || $id === false){
            $this->defineMensagem('danger', 'Curso Inexistente');
            header('Location: /listar-cursos');
            return;
        }

        $curso = $this->entityManager->getReference(Curso::class, $id);
        $this->entityManager->remove($curso);
        $this->entityManager->flush();
        $this->defineMensagem('success', 'Curso excluído com Sucesso');
        
        header('Location: /listar-cursos');
    }
}