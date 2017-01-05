<?php

namespace Application;

/**
 * Front Controller class.
 * Play the router role selcting which controller to call
 */
class FrontController
{
    /**
     * @var string Base namespace for controllers
     */
    protected static $controllersBaseNamespace = "InSided\ImageThread\Controller\\";

    /**
     * Returns default controller name
     *
     * @return string
     */
    protected static function getDefaultController()
    {
        $config = Application::getConfig();
        return self::$controllersBaseNamespace . $config['application']['defaultController'];
    }

    /**
     * Returns default action name
     *
     * @return string
     */
    protected static function getDefaultAction()
    {
        $config = Application::getConfig();
        return $config['application']['defaultAction'];
    }

    /**
     * Returns layout path
     *
     * @return string
     */
    protected static function getLayout()
    {
        $config = Application::getConfig();

        return ROOT_DIR . $config['application']['viewsDir'] . $config['application']['layout'];
    }

    /**
     * Select request controller based on request query_string
     *
     * @param string $requestUri Query string
     * @return string Controller name
     */
    protected static function getRequestController($requestUri)
    {
        $queryString = explode('/', $requestUri);
        if (0 !== count($queryString)
            && file_exists(self::$controllersBaseNamespace . ucfirst($queryString[1]) . 'Controller.php')
        ) {
            return self::$controllersBaseNamespace . ucfirst($queryString[1]) . 'Controller';
        } else {
            return self::getDefaultController();
        }
    }

    /**
     * Select request action based on request query_string
     *
     * @param string $requestUri Query string
     * @return string Action name
     */
    protected static function getRequestAction($requestUri)
    {
        $queryString = explode('/', $requestUri);
        if (count($queryString) > 1 && !empty($queryString[2])) {
            return lcfirst($queryString[2]) . "Action";
        } else {
            return self::getDefaultAction();
        }
    }

    /**
     * Returns request parameters in a common array format
     *
     * @param string $requestMethod GET, POST...
     * @param array $queryString Query string
     * @param array $postParams Post params for post requests
     * @return array
     */
    protected static function getRequestParameters($requestMethod, $queryString, array $postParams)
    {
        $params = array();
        if ('POST' === $requestMethod) {
            return $postParams;
        } else {
            $dirtyParams = (count($queryString) > 2) ? array_slice($queryString, 3) : array();
            for ($n = 0; $n < count($dirtyParams) - 1; $n++) {
                $params[$dirtyParams[$n]] = $dirtyParams[$n + 1];
                $n++;
            }
            return $params;
        }
    }

    /**
     * Executes controller action and captures output into a variable that will be injected
     * into the layout
     *
     * @param string $controller Controller name to be executed
     * @param string $action Action name to be executed
     * @param array $parameters Parameters to pass to action
     * @return string Content
     */
    protected static function getRequestContent($controller, $action, array $parameters)
    {
        $content = '';
        if (!empty($controller) && !empty($action)) {
            ob_start();
            $controllerInstance = new $controller();
            $controllerInstance->$action($parameters);
            $content = ob_get_contents();
            ob_end_clean();
        }
        return $content;
    }

    /**
     * Render layout and inject controller content into it
     *
     * @param string $requestMethod GET, POST...
     * @param string $requestUri Query String
     * @param array $postParams Post params
     * @param array $headers Request headers
     */
    public static function render($requestMethod, $requestUri, array $postParams, array $headers)
    {
        $requestController = self::getRequestController($requestUri);
        $requestAction = self::getRequestAction($requestUri);
        $parameters = self::getRequestParameters($requestMethod, $requestUri, $postParams);
        $content = self::getRequestContent($requestController, $requestAction, $parameters);

        $config = Application::getConfig();
        if (array_key_exists('Ajax-Request', $headers) && 'true' === $headers['Ajax-Request']) {
            echo $content;
        } else {
            require_once self::getLayout();
        }
    }
}
