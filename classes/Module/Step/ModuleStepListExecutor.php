<?php

namespace PrestaShop\Module\PrestashopCheckout\Module\Step;

class ModuleStepListExecutor
{
    /**
     * @var \Ps_checkout
     */
    private $module;

    /**
     * @var ModuleStepInterface[]
     */
    private $steps;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @param \Ps_checkout $module
     * @param ModuleStepInterface[] $steps
     */
    public function __construct(\Ps_checkout $module, array $steps)
    {
        $this->module = $module;
        $this->steps = $steps;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function execute()
    {
        foreach ($this->steps as $step) {
            $step->setModule($this->module);
            try {
                if (false === $step->execute()) {
                    return false;
                }
            } catch (ModuleStepException $exception) {
                $this->errors[] = $exception->getMessage();
            }
        }

        return true;
    }
}
