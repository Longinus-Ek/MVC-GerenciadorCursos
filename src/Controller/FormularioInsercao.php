<?php 

namespace Alura\Cursos\Controller;

use Alura\Cursos\Trait\RenderizadorDeHtmlTrait;

class FormularioInsercao  implements InterfaceControladorRequisicao
{
    use RenderizadorDeHtmlTrait;
    
    public function processaRequisicao() : void
    {
       echo $this->renderizaHtml('cursos/formulario.php', [
            'titulo' => 'Novo Curso'
        ]);
    }
}