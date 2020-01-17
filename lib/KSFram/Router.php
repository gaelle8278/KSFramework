<?php
namespace KSFram;


class Router extends ApplicationComponent
{
    protected $routes = [];
    
    const NO_ROUTE = 1;
    
    public function addRoute(Route $route)
    {
        if (!in_array($route, $this->routes))
        {
            $this->routes[] = $route;
        }
    }
    
    /**
     * Récupération d'une route en fonction d'une url
     * 
     * @param   $url
     * @throws \RuntimeException
     * @return
     */
    public function getRoute($url)
    {
        foreach ($this->routes as $route)
        {
            // Si l'url correspond à un pattern de route
            if (($varsValues = $route->match($url)) !== false)
            {
                // Si la route contient des paramètres à définir
                if ($route->hasVars())
                {
                    $varsNames = $route->varsNames();
                    $listVars = [];
                    
                    // on définit la valeur des paramètres en fonction des paramètres contenus dans l'url
                    foreach ($varsValues as $key => $match)
                    {
                        // La première valeur contient entièrement la chaine capturée donc l'url entière
                        if ($key !== 0)
                        {
                            $listVars[$varsNames[$key - 1]] = $match;
                        }
                    }
                    
                    // On assigne les valeurs de paramètres à la route
                    $route->setVars($listVars);
                }
                
                return $route;
            }
        }
        
        throw new \RuntimeException('Aucune route ne correspond à l\'URL', self::NO_ROUTE);
    }
}

