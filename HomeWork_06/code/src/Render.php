<?php

namespace Geekbrains\Application1;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Exception;

class Render {

    private string $viewFolder = '/src/Views/';
    private FilesystemLoader $loader;
    private Environment $environment;


    public function __construct(){

        $this->loader = new FilesystemLoader(dirname(__DIR__) . $this->viewFolder);
        $this->environment = new Environment($this->loader, [
           // 'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);
    }

    public function renderPage(string $contentTemplateName = 'page-index.twig', array $templateVariables = []) {
        $template = $this->environment->load('main.twig');

        $templateVariables['content_template_name'] = $contentTemplateName;
        $templateVariables['content_header_name'] = 'header.twig';
        $templateVariables['content_footer_name'] = 'footer.twig';

        return $template->render($templateVariables);
    }

    public static function renderExceptionPage(Exception $exception): string {
        $contentTemplateName = "error.twig";
        $viewFolder = '/src/Views/';

        $loader = new FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . $viewFolder);
        $environment = new Environment($loader, [
            //  'cache' => $_SERVER['DOCUMENT_ROOT'].'/cache/',
        ]);

        $template = $environment->load('main.twig');
        
        $templateVariables['content_template_name'] = $contentTemplateName;
        $templateVariables['content_header_name'] = 'header.twig';
        $templateVariables['content_footer_name'] = 'footer.twig';
        $templateVariables['error_message'] = $exception->getMessage();
 
        return $template->render($templateVariables);
    }
}