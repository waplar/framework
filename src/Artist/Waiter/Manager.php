<?php

namespace Artist\Waiter;

class Manager
{

    /**
     * @var array
     */
    private array $stubs = [];

    /**
     * @var array
     */
    private array $summaries = [];

    /**
     * @var array
     */
    private array $models = [];

    /**
     * @return array
     */
    public function getStubs(): array
    {
        return $this->stubs;
    }

    /**
     * @return array
     */
    public function getSummaries(): array
    {
        return $this->summaries;
    }

    /**
     * @return array
     */
    public function getModels(): array
    {
        return $this->models;
    }

    /**
     * @param string $uuid
     *
     * @return string
     */
    public function getSummary(string $uuid): string
    {
        return $this->summaries[$uuid];
    }

    /**
     * @param string $uuid
     *
     * @return string
     */
    public function getModel(string $uuid): string
    {
        return $this->models[$uuid];
    }

    /**
     * @param string $uuid
     * @param array  $value
     *
     * @return static
     */
    public function appendStub(string $uuid, array $value): static
    {
        $this->stubs[$uuid] = $value;

        return $this;
    }

    /**
     * @param string $uuid
     * @param string $value
     *
     * @return static
     */
    public function appendSummary(string $uuid, string $value): static
    {
        $this->summaries[$uuid] = $value;

        return $this;
    }

    /**
     * @param string $uuid
     * @param string $value
     *
     * @return static
     */
    public function appendModel(string $uuid, string $value): static
    {
        $this->models[$uuid] = $value;

        return $this;
    }

}
