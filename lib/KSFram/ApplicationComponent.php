<?php
namespace KSFram;

/**
 * Classe parente des composants du Framework
 * 
 * Permet de savoir par quelle application est utilisé le composant
 * 
 * @author gaelle
 *
 */
abstract class ApplicationComponent
{
    protected $app;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    public function app()
    {
        return $this->app;
    }
}

