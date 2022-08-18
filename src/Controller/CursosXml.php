<?php 

namespace Alura\Cursos\Controller;

use SimpleXMLElement;
use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Curso;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CursosXml implements RequestHandlerInterface
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->respositorioDeCursos = $entityManager->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        /** @var Curso[] $cursos */
        $cursos = $this->respositorioDeCursos->findAll();
        $cursosEmXml = new SimpleXMLElement('<cursos/>');

        foreach($cursos as $curso){
            $cursoEmXml = $cursosEmXml->addChild('curso');
            $cursoEmXml->addChild('id', $curso->getId());
            $cursoEmXml->addChild('descricao', $curso->getDescricao());
        }
        return new Response(200, ['Content-Type' => 'application/xml'], $cursosEmXml->asXML());
    }
    
}

