<?php

declare(strict_types=1);

namespace DanLapteacru\FacetWpBuilder\Traits;

/**
 * Builder trait.
 */
trait Builder
{
    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * Set a config key -> value pair
     *
     * @return $this
     */
    public function setConfig(string $key, mixed $value): static
    {
        return $this->updateConfig([$key => $value]);
    }

    /**
     * Update multiple config values using and array of key -> value pairs.
     *
     * @param array $config
     * @return $this
     */
    public function updateConfig(array $config): static
    {
        $this->config = array_merge($this->config, $config);
        return $this;
    }

    public function getName(): string
    {
        return $this->config['name'];
    }

    public function getKey(): string
    {
        return $this->config['key'];
    }

    public function getLabel(): string
    {
        return $this->config['label'];
    }

    public function transformOptionValue(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'yes' : 'no';
        }

        if (is_array($value)) {
            $value = array_map([$this, 'transformOptionValue'], $value);
            return implode(', ', $value);
        }

        return (string) $value;
    }

    /**
     * @return $this
     */
    public function setKey(string $key): static
    {
        return $this->setConfig('type', $key);
    }
}
