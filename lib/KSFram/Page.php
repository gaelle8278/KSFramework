<?php
namespace KSFram;

/**
 * Page permet 
 * - d'ajouter une variable à la page (le contrôleur aura besoin de passer des données à la vue).
 * - d'assigner une vue à la page.
 * - de générer la page avec le layout de l'application.
 */
class Page extends ApplicationComponent
{
    protected $contentFile;
    protected $vars = [];
    
    public function addVar($var, $value)
    {
        if (!is_string($var) || is_numeric($var) || empty($var))
        {
            throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères non nulle');
        }
        
        $this->vars[$var] = $value;
    }
    
    public function getGeneratedPage()
    {
        if (!file_exists($this->contentFile))
        {
            throw new \RuntimeException('La vue spécifiée n\'existe pas');
        }
        
        extract($this->vars);
        
        ob_start();
        require $this->contentFile;
        $content = ob_get_clean();
        
        ob_start();
        require __DIR__.'/../../App/'.$this->app->name().'/templates/layout.php';
        return ob_get_clean();
    }
    
    public function setContentFile($contentFile)
    {
        if (!is_string($contentFile) || empty($contentFile))
        {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }
        
        $this->contentFile = $contentFile;
    }
}