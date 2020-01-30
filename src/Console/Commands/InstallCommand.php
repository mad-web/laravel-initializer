<?php

namespace MadWeb\Initializer\Console\Commands;

use Illuminate\Contracts\Container\Container;

class InstallCommand extends AbstractInitializeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the application according to current environment';

    /**
     * Create a new command instance.
     *
     * @param  Illuminate\Contracts\Container\Container  $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->signature = 'app:install
                            {--root : Run commands which requires root privileges}
                            {--o|options=* : Run commands for custom options'.$this->getOptionsConfig($container).'}';

        parent::__construct();
    }

    /**
     * Returns instance of Install class which defines initializing runner chain.
     *
     * {@inheritdoc}
     */
    protected function getInitializerInstance(Container $container)
    {
        return $container->make('app.installer');
    }

    protected function title(): string
    {
        return 'Application installation';
    }

    protected function getOptionsConfig(Container $container)
    {
        $config = $container->make('config');
        $env = $config->get($config->get('initializer.env_config_key'));
        $options = $config->get($config->get('initializer.options.'.$env.'.install'));

        $options = array_keys($options);

        if (count($options) > 0) {
            return '. Allowed options:['.implode(', ', $options).']';
        }
    }
}
