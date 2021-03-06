<?php

namespace Technodelight\Jira\Configuration\ApplicationConfiguration;

use Technodelight\Jira\Configuration\ApplicationConfiguration\RendererConfiguration\FieldConfiguration;

class RendererConfiguration
{
    /** @var string */
    private $name;
    /** @var bool */
    private $inherit;
    /** @var FieldConfiguration[] */
    private $fields;

    public static function fromArray(array $config)
    {
        $instance = new self;
        $instance->name = $config['name'];
        $instance->inherit = isset($config['inherit']) ? $config['inherit'] : true;
        $instance->fields = array_map(
            function(array $field) {
                return FieldConfiguration::fromArray($field);
            },
            isset($config['fields']) ? $config['fields'] : []
        );

        return $instance;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function inherit()
    {
        return $this->inherit;
    }

    /**
     * @return FieldConfiguration[]
     */
    public function fields()
    {
        return $this->fields;
    }

    private function __construct()
    {
    }
}
