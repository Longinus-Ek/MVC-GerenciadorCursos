<?php 

namespace Alura\Cursos\Trait;

trait FlashMessageTrait
{

    public function defineMensagem (string $tipo, string $mensagem) : void
    {
        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['tipoMensagem'] = $tipo;
    }
}