<?php
namespace KSFram;

/**
 * Classe principale, initiale dont h�ritera toute application
 * 
 * @author gaelle
 *
 */
abstract class Application
{
    protected $httpRequest;
    protected $httpResponse;
    protected $router;
    protected $name;
    protected $user;
    protected $config;
    
    public function __construct()
    {
        $this->httpRequest = new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);
        $this->router = new Router($this);
        $this->user = new User($this);
        $this->config = new Config($this);
        $this->name = '';
    }
    
    abstract public function run();
    
    /**
     * Retounr le bon controller en fonction de l'url
     * 
     * @return 
     */
    public function getController()
    {
        
        //1. Parsing du fichier des routes pour alimenter le router
        //@TODO devrait être encapsulé dans une classe dédiée et une méthode dédiée de Application
        $xml = new \DOMDocument;
        $xml->load(__DIR__.'/../../app/'.$this->name.'/config/routes.xml');
        
        $routes = $xml->getElementsByTagName('route');
        
        // On parcourt les routes du fichier XML.
        foreach ($routes as $route)
        {
            $vars = [];
            
            // On regarde si des variables sont présentes dans l'URL.
            if ($route->hasAttribute('vars'))
            {
                $vars = explode(',', $route->getAttribute('vars'));
            }
            
            // On ajoute la route au routeur.
            $this->router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
        }
        
        //2. Récupération de la route en fonction de l'url
        try
        {
            $matchedRoute = $this->router->getRoute($this->httpRequest->requestURI());
        }
        catch (\RuntimeException $e)
        {
            if ($e->getCode() == Router::NO_ROUTE)
            {
                $this->httpResponse->redirect404();
            }
        }
        
        // On ajoute les variables de l'URL au tableau $_GET ?
        $_GET = array_merge($_GET, $matchedRoute->vars());
        
        // 3. On instancie le contrôleur.
        $controllerClass = 'app\\'.$this->name.'\\modules\\'.$matchedRoute->module().'\\'.$matchedRoute->module().'Controller';
        
        return new $controllerClass($this, $matchedRoute->module(), $matchedRoute->action());
    }
    
    
    public function httpRequest()
    {
        return $this->httpRequest;
    }
    
    public function httpResponse()
    {
        return $this->httpResponse;
    }
    
    public function name()
    {
        return $this->name;
    }
    
    public function router() {
        return $this->router;
    }
}

