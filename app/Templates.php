<?php

namespace App;

class Templates
{
    public function __construct($path, $args = null, $nivel = '')
    {
        $args['CSS'] = $this->generateCss();
        $args['JS'] = $this->generateJs();

        $template = $this->getTemplate($path);
        echo $this->parseTemplate($template, $args);
    }

    protected function getTemplate($template, $folder = "web/")
    {
        $arqTemp = $folder.$template;
        $content = '';

        if (is_file($arqTemp)) {
            $content = file_get_contents($arqTemp);
        }

        return $content;
    }
    
    protected function parseTemplate($template, $array)
    {
        foreach ($array as $a => $b) {
            if (strpos($a, 'list')) {
                $template = str_replace('{'.$a.'}', json_encode($b), $template);
            } else {
                $template = str_replace('{'.$a.'}', $b, $template);
            }
        }

        return $template;
    }

    protected function generateCss()
    {
        $rootUrl = substr(url(), 0, strlen(url()) - 1);
        $rootUrl = count(explode("/", $rootUrl)) - 2;

        $backwards = '';
        for ($i = 1; $i <= $rootUrl; $backwards .= "../", $i++);

        $cssFiles = ['css', 'glyphicons', 'navbar'];
        $cssPaths = '';
        foreach ($cssFiles as $cssFile)
        {
            $cssPaths .= "<link href='" . $backwards . "includes/css/$cssFile.css' rel='stylesheet'>";
        }
        return $cssPaths;
    }

    protected function generateJs()
    {
        $rootUrl = substr(url(), 0, strlen(url()) - 1);
        $rootUrl = count(explode("/", $rootUrl)) - 2;

        $backwards = '';
        for ($i = 1; $i <= $rootUrl; $backwards .= "../", $i++);

        $jsFiles = ['jquery', 'height', 'detect'];
        $jsPaths = '';
        foreach ($jsFiles as $jsFile)
        {
            $jsPaths .= "<script src='" . $backwards . "includes/js/$jsFile.js'></script>";
        }
        return $jsPaths;
    }

    protected function createUrl($url)
    {
        return substr(url($url), 0, strlen($url) + 1);
    }
}
