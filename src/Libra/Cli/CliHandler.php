<?php

namespace Libra\Cli;

class CliHandler
{
    private $arguments;
    private $action;
    private $options = [];
    private $parameters = [];
    
    function __construct($arguments)
    {
        $this->arguments = $arguments;
        $this->parseArguments();
    }
    
    private function parseArguments()
    {
        // remove first entry
        unset($this->arguments[0]);
        $this->arguments = array_values($this->arguments);
    
        // loop through arguments
        foreach($this->arguments as $argument) {
            list($option, $value) = explode('=', $argument, 2);
    
            // handle each argument
            switch($option) {
                case 'action':
                    $this->setAction(strtolower($value));
                    break;
                    
                // options
                case 'json':
                case 'json_pretty':
                case 'dump':
                case 'output':
                    $this->addOption($option, $value);
                    break;
                    
                // data fetch query params
                case 'table':
                case 'where':
                case 'limit':
                case 'columns':
                    $this->addParameter($option, $value);
                    break;
            }
        }
    }
    
    /**
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }
    
    /**
     * @param mixed $arguments
     * @return CliHandler
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * @param mixed $action
     * @return CliHandler
     */
    public function setAction($action)
    {
        $this->action = $action;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }
    
    /**
     * @param $option
     * @param bool $default
     * @return bool|mixed
     */
    public function getOption($option, $default = false)
    {
        return $this->options[$option] ?? $default;
    }
    
    
    /**
     * @param mixed $options
     * @return CliHandler
     */
    public function setOptions($options)
    {
        $this->options = $options;
        
        return $this;
    }
    
    /**
     * @param $option
     * @param $value
     * @return $this
     */
    public function addOption($option, $value)
    {
        $this->options[$option] = $value;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getParameters()
    {
        return $this->parameters;
    }
    
    /**
     * @param $parameter
     * @return mixed
     */
    public function getParameter($parameter)
    {
        return $this->parameters[$parameter] ?? false;
    }
    
    /**
     * @param mixed $parameters
     * @return CliHandler
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        
        return $this;
    }
    
    /**
     * @param $parameter
     * @param $value
     * @return $this
     */
    public function addParameter($parameter, $value)
    {
        $this->parameters[$parameter] = $value;
        
        return $this;
    }
}