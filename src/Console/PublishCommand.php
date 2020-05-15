<?php


namespace Encore\SelectInlineCreate\Console;


use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'admin:select-inline-create:publish {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "re-publish laravel-admin's for SelectInlineCreate package assets and language files. If you want overwrite the existing files, you can add the `--force` option";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $force = $this->option('force');
        $options = ['--provider' => 'Encore\SelectInlineCreate\SelectInlineCreateServiceProvider'];
        if ($force == true) {
            $options['--force'] = true;
        }
        $this->call('vendor:publish', $options);

        $options = ['--provider' => 'Encore\ModalForm\ModalFormServiceProvider'];
        if ($force == true) {
            $options['--force'] = true;
        }
        $this->call('vendor:publish', $options);
    }

}
