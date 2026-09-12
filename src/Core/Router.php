<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Router — Matches HTTP requests to controller actions.
 *
 * Supports:
 *   - GET, POST, PUT, DELETE methods
 *   - Route parameters via {name} syntax (e.g. /users/{id})
 *   - Automatic base-path stripping for subdirectory installations
 *
 * Usage (in config/routes.php):
 *   $router->get('/register', [AuthController::class, 'showRegisterForm']);
 *   $router->post('/register', [AuthController::class, 'register']);
 */
class Router
{
    /** @var array Registered routes */
    private array $routes = [];

    // -----------------------------------------------------------------
    //  Route Registration
    // -----------------------------------------------------------------

    public function get(string $path, array $handler, array $middlewares = []): self
    {
        return $this->addRoute('GET', $path, $handler, $middlewares);
    }

    public function post(string $path, array $handler, array $middlewares = []): self
    {
        return $this->addRoute('POST', $path, $handler, $middlewares);
    }

    public function put(string $path, array $handler, array $middlewares = []): self
    {
        return $this->addRoute('PUT', $path, $handler, $middlewares);
    }

    public function delete(string $path, array $handler, array $middlewares = []): self
    {
        return $this->addRoute('DELETE', $path, $handler, $middlewares);
    }

    private function addRoute(string $method, string $path, array $handler, array $middlewares = []): self
    {
        $this->routes[] = compact('method', 'path', 'handler', 'middlewares');
        return $this;
    }

    // -----------------------------------------------------------------
    //  Dispatching
    // -----------------------------------------------------------------

    /**
     * Match the current request against registered routes and invoke the handler.
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = $this->resolveUri();

        foreach ($this->routes as $route) {
            $params = [];

            if ($route['method'] === $method && $this->matchPath($route['path'], $uri, $params)) {
                
                foreach ($route['middlewares'] as $middleware) {
                    $m = new $middleware();
                    $m->handle();
                }

                [$controllerClass, $action] = $route['handler'];

                $controller = new $controllerClass();
                call_user_func_array([$controller, $action], $params);
                return;
            }
        }

        // No route matched — 404
        http_response_code(404);
        echo '<h1>404 &mdash; Page Not Found</h1>';
    }

    // -----------------------------------------------------------------
    //  Internals
    // -----------------------------------------------------------------

    /**
     * Extract the clean route path from the request URI.
     * Strips the base directory (e.g. /WEB/public) so routes use clean paths like /register.
     */
    private function resolveUri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Determine the base path from SCRIPT_NAME (e.g. /WEB/public/index.php → /WEB/public)
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);

        if ($scriptDir !== '/' && $scriptDir !== '\\' && str_starts_with($uri, $scriptDir)) {
            $uri = substr($uri, strlen($scriptDir));
        }

        return '/' . trim($uri, '/');
    }

    /**
     * Check if a route pattern matches the URI.
     * Converts {param} placeholders to named regex groups.
     *
     * @param  string $pattern  Route pattern (e.g. /users/{id})
     * @param  string $uri      Clean request URI (e.g. /users/42)
     * @param  array  $params   Extracted route parameters (populated by reference)
     * @return bool
     */
    private function matchPath(string $pattern, string $uri, array &$params): bool
    {
        // Convert {name} to named capture groups
        $regex = preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';

        if (preg_match($regex, $uri, $matches)) {
            // Keep only named captures (string keys), discard numeric keys
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return true;
        }

        return false;
    }
}
